<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database
  Due date: Nov 23 2016
-->
<?php
  $HOSTNAME = 'localhost';
  $DATABASE = 'cheapbooks';
  $USERNAME = 'root';
  $PASSWORD = '';

  $CONNECTION_STRING = 'mysql:host='.$HOSTNAME.':3306;dbname='.$DATABASE;

  $validUser = false;
  $showSearchTable = false;
  $searchText = '';

  session_start();

  if(!isset($_SESSION['username'])){
   echo '
        <h1>Error: No user session available</h1>
        <h3>Redirecting to login page in <span id="ctx">8</span> seconds...</h3>
        <script>
          var counter = 7;
          function countdown(){
            var elem = document.getElementById("ctx");
            elem.innerHTML = counter--;

            if(counter == 0)
              location.href = "page1.php";
          }
          setInterval(countdown, 1000);
        </script>
      ';
    die();
  } else {
   // User already has a session
   $username = $_SESSION['username'];

   $validUser = true;
   $isbns = '';

   $dbh = new PDO($CONNECTION_STRING, $USERNAME, $PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   
   // Search
   if(isset($_POST['searchBy']) && $_POST['searchBy'] != '') {
      try {
       $searchText = $_POST['searchText'];
       $searchTextQStr = '%'.$searchText.'%';

       if($_POST['searchBy'] == 'title'){
         $stmt = $dbh->prepare("SELECT ISBN FROM book WHERE title LIKE :booktitle");
         $stmt->bindParam(':booktitle', $searchTextQStr);
       } else {
         $stmt = $dbh->prepare("SELECT ISBN FROM book WHERE ISBN = (SELECT ISBN FROM writtenby WHERE ssn = (SELECT ssn FROM author WHERE name LIKE :authorname))");
         $stmt->bindParam(':authorname', $searchTextQStr);
       }

       $isFirst = true;
       if($stmt->execute()){

          while ($row = $stmt->fetch()) {
            if(!$isFirst){
              $isbns = $isbns.",";
            } else {
              $isFirst = false;
            }

            $isbns = $isbns."'".$row['ISBN']."'";
          }

          
          $showSearchTable = true;
       } else {
         echo 'stmt execute failed';
       }
     } catch (Exception $e) {
        echo 'Exception';
     }
   } else if(isset($_POST['addToBasket']) && $_POST['addToBasket'] != ''){
     // Add to Basket
     $isbn = $_POST['addToBasket'];

     $b_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';
     $stmt = $dbh->prepare($b_sql);

     if($stmt->execute()){
        $row = $stmt->fetch();

        $basketID = $row['basketID'];

        if($basketID == ''){
          $uniqueBasketID = uniqid();

          $dbh->beginTransaction();
          $dbh->exec('INSERT INTO shoppingbasket VALUES("'.$uniqueBasketID.'","'.$username.'")');
          $dbh->exec('INSERT INTO contains VALUES("'.$isbn.'","'.$uniqueBasketID.'",1)');
          $dbh->commit();

        } else {
          $b_sql = 'UPDATE contains SET number = number + 1 WHERE basketID = "'.$basketID.'" AND ISBN = "'.$isbn.'"';
          $stmt = $dbh->prepare($b_sql);
          $stmt->execute();

          // First time addition
          if($stmt->rowCount() == 0){
            $dbh->beginTransaction();
            $dbh->exec('INSERT into contains values("'.$isbn.'","'.$basketID.'",1)');
            $dbh->commit();
          }
        }
     }
   }
  }

  //print_r($_POST);
  $basketCount = '0';
  $sql = "SELECT COUNT(ISBN) bCount FROM  contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username='".$_SESSION['username']."')";
  
  // Check shopping basket
  $stmt = $dbh->prepare($sql);
  
  if($stmt->execute()){
    $row = $stmt->fetch();
    $basketCount = $row['bCount'];
  }

  if(!$showSearchTable)
    $dbh = null;    
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cheapbooks Home</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
          <?php
            if($validUser){
              echo '<div id="userInfoDiv">';
              echo '<span id="userInfo">Logged in as : '.$_SESSION['username'].'</span>';
              echo '<input id="logoutBtn" type="button" value="Log out" />
              </div>';
            }
           ?>
        </div>
      </div>
      <div id="container">
        <div id="searchContainer">
          <div id="searchTextHeader">Search CheapBooks</div>
          <span>
            <form id="searchForm" class="" action="page2.php" method="post">
              <input type="hidden" id="searchBy" name="searchBy" value="title">
              <input type="hidden" id="addToBasket" name="addToBasket" value="">
              <input id="searchText" type="text" name="searchText" value="<?php echo $searchText;?>" />
              <div class="searchBtns">
                <input type="button" id="searchBtnAuthor" name="searchBtnAuthor" value="Search by Author">
                <input type="button" id="searchBtnTitle" name="searchBy" value="Search by Title">
                <input type="button" id="shoppingBasketBtn" data="<?php echo $basketCount ?>" value="Shopping Basket (<?php echo $basketCount ?>)">
              </div>
            </form>
          </span>
        </div>

        <?php

          if ($showSearchTable) {
            echo '<div id="bookList">
                  <h2 class="center-text">Search Results</h2>';
            
            if($isbns != ''){
              echo
                '<table id="booksTable" cellspacing="10">
                  <thead>
                    <tr>
                      <td class="padding-left-10">Name</td>
                      <td>ISBN</td>
                      <td>Stock</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>';

              $stmt = $dbh->prepare('SELECT bk.title, bkstocks.ISBN, bkstocks.stock FROM (SELECT stks.ISBN, SUM(stks.number) as stock FROM stocks stks WHERE stks.ISBN IN ('.$isbns.') AND stks.number > 0 GROUP BY stks.ISBN) bkstocks, book bk WHERE bkstocks.ISBN = bk.ISBN');

              if($stmt->execute()){
                while($row = $stmt->fetch()){
                  echo '<tr>';
                  echo '<td class="padding-left-10">'.$row['title'].'</td>';
                  echo '<td>'.$row['ISBN'].'</td>';
                  echo '<td>'.$row['stock'].'</td>';
                  echo '<td class="addToBasketCol"><input type="button" class="addToBasketBtn" data="'.$row['ISBN'].'" value="Add to Basket" ></td>';
                  echo '</tr>';
                }
              }    
              
              echo
                  '</tbody>
                </table>';
              
              $dbh = null;
            } else {
              echo '<h3 class="center-text"> No matching book(s) found.</h3>';
            }
            
            echo '</div>';
          } 
         ?>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#searchForm').submit(function(e){
          if($('#searchText').val() === '' && $('#addToBasket').val() == ''){
            alert('Enter some text');
            e.preventDefault();
            return;
          }
        });

        $('#logoutBtn').click(function(e){
          location.href="page1.php";
        });

        $('#searchBtnAuthor').click(function(e){
          $('#searchBy').val('author');
          $('#searchForm').submit();
        });

        $('#searchBtnTitle').click(function(e){
          $('#searchBy').val('title');
          $('#searchForm').submit();
        });

        $('#shoppingBasketBtn').click(function(){
          location.href = "page3.php";
        });

        $('.addToBasketBtn').click(function(){
          $('#searchBy').val('');
          $('#addToBasket').val($(this).attr('data'));
          $('#searchForm').submit();
        });

        document.getElementById('logo').onclick = function(){location.href='page2.php';};
      });
    </script>
  </body>
</html>
