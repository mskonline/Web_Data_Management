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
        </div>
      </div>
      <div id="container">
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
                '<div id="shoppingBasketList">
                  <h2 style="text-align:center">Your Shopping Basket</h2>
                  <h3>Total Items: '.$totalItems.'</h3>
                  <table id="shoppingbasketTable" cellspacing="10">
                    <thead>
                      <tr>
                        <th style="padding-left:10px;">Title</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th style="text-align:right;padding-right:10px;">Price</th>
                      </tr>
                    </thead>
                    <tbody>';

              while($row = $stmt->fetch()){
                echo '<tr>';
                echo '<td style="padding-left:10px;">'.$row['title'].'</td>';
                echo '<td>'.$row['publisher'].'</td>';
                echo '<td>'.$row['ISBN'].'</td>';
                echo '<td style="text-align:right;padding-right:10px;">'.$row['price'].'</td>';
                echo '</tr>';

                $totalBasketPrice += $row['price'];
              }

              echo '<tr><td style="padding-left:10px;" colspan="3">Total</td><td style="text-align:right;padding-right:10px;"> $'.$totalBasketPrice.'</td></tr>';

              echo
                    '</tbody>
                  </table>


                  <div id="buyBtnDiv"><div class="buyButton">Back</div><div class="buyButton">Buy</div></div>
                </div>';

              $dbh = null;
            } else {
              // Empty basket
              echo '<h3>Your Shopping is empty. Select your books <a href="page2.php">here</a></h3>';
            } 
          }
        ?>
      </div>
      <div id="footer"></div>
    </div>
  </body>
  <script type="text/javascript">
    document.getElementById('logo').onclick = function(){location.href='page2.php';};
  </script>
</html>
