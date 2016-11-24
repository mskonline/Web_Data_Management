<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database
  Due date: Nov 26 2016
-->
<?php
  $HOSTNAME = 'localhost';
  $DATABASE = 'cheapbooks';
  $USERNAME = 'root';
  $PASSWORD = '';

  $CONNECTION_STRING = 'mysql:host='.$HOSTNAME.':3306;dbname='.$DATABASE;

  session_start();
  $showShoppingBasket = true;

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
  }

  if(isset($_POST['basketAction'])){
    $username = $_SESSION['username'];

    $dbh = new PDO($CONNECTION_STRING, $USERNAME, $PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $w_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';
    $stmt = $dbh->prepare($w_sql);

    if($stmt->execute()){
      if($stmt->rowCount() > 0){
        $row = $stmt->fetch(); 
        $basketID = $row['basketID'];

        $w_sql = 'SELECT ISBN, number FROM contains WHERE basketID="'.$basketID.'"';
        $stmt = $dbh->prepare($w_sql);

        if($stmt->execute()){
          
          // For every ISBN update Warehouse and add Shipping order
          while($row = $stmt->fetch()){
            $isbn = $row['ISBN'];
            $number = $row['number'];

            // Update warehouse stock
            $w_sql = 'SELECT warehouseCode FROM stocks WHERE number = (SELECT MAX(number) FROM stocks WHERE ISBN = "'.$isbn.'")';

            $w_stmt = $dbh->prepare($w_sql);
            $w_stmt->execute();
            $w_row = $w_stmt->fetch();

            if($w_row['warehouseCode'] != ''){
              $warehouseCode = $w_row['warehouseCode'];
              $dbh->beginTransaction();
              $dbh->exec('UPDATE stocks SET number = number - '.$number.' WHERE  ISBN ="'.$isbn.'" AND warehouseCode='.$warehouseCode);
              $dbh->exec('INSERT INTO shippingorder VALUES("'.$isbn.'", '.$warehouseCode.', "'.$username.'",'.$number.')');
              $dbh->commit();
            }
          } // while

          //Remove basket
          $dbh->beginTransaction();
          $dbh->exec('DELETE FROM shoppingbasket WHERE username="'.$username.'"');
          $dbh->exec('DELETE FROM contains WHERE basketID="'.$basketID.'"');
          $dbh->commit();

        } // if stmt->execute() ISBN
      } // if stmt->rowCount() ISBN
    } // if stmt->execute() BasketID
  } // if basketAction set
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CheapBooks</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
          <?php
            echo '<div id="userInfoDiv">';
            echo '<span id="userInfo">Logged in as : '.$_SESSION['username'].'</span>';
            echo '<input id="logoutBtn" type="button" value="Log out" />
            </div>';
           ?>
        </div>
        <div id="strip"></div>
      </div>
      <div id="container">
      <div id="shoppingBasketList">
      <h2 class="center-text">Your Shopping Basket</h2>
        <?php
          $username = $_SESSION['username'];

          $dbh = new PDO($CONNECTION_STRING, $USERNAME, $PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
          $sql = 'SELECT * FROM book WHERE ISBN IN (SELECT ISBN FROM contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username="'.$username.'"))';

          $stmt = $dbh->prepare($sql);

          if($stmt->execute()){

            $totalBasketPrice = 0;
            $totalItems = $stmt->rowCount();

            if($totalItems > 0){

              echo 
                 '<h3>Total Items: '.$totalItems.'</h3>
                  <table id="shoppingbasketTable" cellspacing="10">
                    <thead>
                      <tr>
                        <th class="padding-left-10">Title</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th style="text-align:right;padding-right:10px;">Price</th>
                      </tr>
                    </thead>
                    <tbody>';

              while($row = $stmt->fetch()){
                echo '<tr>';
                echo '<td class="padding-left-10">'.$row['title'].'</td>';
                echo '<td>'.$row['publisher'].'</td>';
                echo '<td>'.$row['ISBN'].'</td>';
                echo '<td style="text-align:right;padding-right:10px;"> $'.$row['price'].'</td>';
                echo '</tr>';

                $totalBasketPrice += $row['price'];
              }

              echo '<tr><td class="padding-left-10" colspan="3">Total</td><td id="totalPriceCell"> $'.$totalBasketPrice.'</td></tr>';

              echo
                    '</tbody>
                  </table>
                  <div id="btnDiv">
                    <div id="backButton" class="actionButton">Back</div>
                    <div id="buyButton" class="actionButton">Buy</div>
                  </div>
                  <form id="buyBooksForm" action="page3.php" method="post">
                    <input type="hidden" name="basketAction" value="buyBasket" />
                  </form>';

              $dbh = null;
            } else {
              
              if(isset($_POST['basketAction']))
                echo '<h3 class="center-text">Order placed. Thank you for shopping with us. Shop more <a href="page2.php">here</a></h3>';
              else
                echo '<h3 class="center-text">Your Basket is empty. Select your books <a href="page2.php">here</a></h3>';
            }
          }
        ?>
      </div>
      </div>
      <div id="footer"></div>
    </div>
  </body>
  <script type="text/javascript">
    document.getElementById('logo').onclick = function(){
      location.href='page2.php';
    };

    document.getElementById('backButton').onclick = function(){
      location.href='page2.php';
    };

    document.getElementById('buyButton').onclick = function(){
      document.getElementById('buyBooksForm').submit();
    };
  </script>
</html>
