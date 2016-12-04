<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with Laravel
  Due date: Dec 5 2016
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="csrf-token" content="<?php echo csrf_token();?>">
    <title>CheapBooks</title>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
          <?php
            echo '<div id="userInfoDiv">';
            echo '<span id="userInfo">Logged in as : '.$username.'</span>';
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
            $totalBasketPrice = 0;
            $totalItems = count($basketItems);

            if($totalItems > 0){
              echo 
                 '<h3>Total Items: '.$totalItems.'</h3>
                  <table id="shoppingbasketTable" cellspacing="10">
                    <thead>
                      <tr>
                        <th class="padding-left-10">Book Title</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th>Quantity</th>
                        <th style="text-align:right;padding-right:10px;">Price</th>
                      </tr>
                    </thead>
                    <tbody>';

              foreach ($basketItems as $row){
                $bookPrice = $row->price * $row->number;
                echo '<tr>';
                echo '<td class="padding-left-10">'.$row->title.'</td>';
                echo '<td>'.$row->publisher.'</td>';
                echo '<td>'.$row->ISBN.'</td>';
                echo '<td>'.$row->number.'</td>';
                echo '<td style="text-align:right;padding-right:10px;"> $'.$bookPrice.'</td>';
                echo '</tr>';

                $totalBasketPrice += $bookPrice;
              }

              echo '<tr><td class="padding-left-10" colspan="4">Total</td><td id="totalPriceCell"> $'.$totalBasketPrice.'</td></tr>';

              echo
                    '</tbody>
                  </table>
                  <div id="btnDiv">
                    <div id="backButton" class="actionButton">Back</div>
                    <div id="buyButton" class="actionButton">Buy</div>
                  </div>
                  <form id="buyBooksForm" action="page3" method="post">'.csrf_field().'
                    <input type="hidden" name="basketAction" value="buyBasket" />
                  </form>';
            } else {
              if(isset($_POST['basketAction']))
                echo '<h3 class="center-text">Order placed. Thank you for shopping with us. Shop more <a href="page2">here</a></h3>';
              else
                echo '<h3 class="center-text">Your Basket is empty. Select your books <a href="page2">here</a></h3>';
            }
          
        ?>
      </div>
      </div>
      <div id="footer"></div>
    </div>
  </body>
  <script type="text/javascript">
    window.onload = function(){
      document.getElementById('logo').onclick = function(){
        location.href='page2';
      };

      if(document.getElementById('backButton')){
        document.getElementById('backButton').onclick = function(){
          location.href='page2';
        };
      }
      
      if(document.getElementById('buyButton')){
        document.getElementById('buyButton').onclick = function(){
          document.getElementById('buyBooksForm').submit();
        };
      }

      document.getElementById('logoutBtn').onclick = function(){
        location.href='page1';
      };
    };
  </script>
</html>