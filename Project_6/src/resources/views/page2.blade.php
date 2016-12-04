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
    <title>Cheapbooks Home</title>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
          <?php
            if($validUser){
              echo '<div id="userInfoDiv">';
              echo '<span id="userInfo">Logged in as : '.$username.'</span>';
              echo '<input type="button" id="shoppingBasketBtn" data="'.$basketCount.'" value="Shopping Basket ('.$basketCount.')" />';
              echo '<input id="logoutBtn" type="button" value="Log Out" />
              </div>';
            }
           ?>
        </div>
        <div id="strip"></div>
      </div>
      <div id="container">
        <div id="searchContainer">
          <div id="searchTextHeader">Search CheapBooks</div>
          <span>
            <form id="searchForm" class="" action="page2" method="post">
			  {{ csrf_field() }}
              <input type="hidden" id="searchBy" name="searchBy" value="title">
              <input type="hidden" id="addToBasket" name="addToBasket" value="">
              <input id="searchText" type="text" name="searchText" value="<?php echo $searchText;?>" />
              <div class="searchBtns">
                <input type="button" id="searchBtnAuthor" name="searchBtnAuthor" value="Search by Author">
                <input type="button" id="searchBtnTitle" name="searchBy" value="Search by Title">     
              </div>
            </form>
          </span>
        </div>

        <?php
          if ($showSearchTable) {
            echo '<div id="bookList">
                  <h2 class="center-text">Search Results</h2>';
            
            if(count($searchResults) > 0){
              echo
                '<table id="booksTable" cellspacing="10">
                  <thead>
                    <tr>
                      <td class="padding-left-10">Book Name</td>
                      <td>ISBN</td>
                      <td>Stock</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>';

              
              foreach ($searchResults as $row){
                echo '<tr>';
                echo '<td class="padding-left-10">'.$row->title.'</td>';
                echo '<td>'.$row->ISBN.'</td>';
                echo '<td>'.$row->stock.'</td>';
                echo '<td class="addToBasketCol"><input type="button" class="addToBasketBtn" data="'.$row->ISBN.'" value="Add to Basket" ></td>';
                echo '</tr>';
              }
                 
              echo
                  '</tbody>
                </table>';
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
          location.href="page1";
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
          location.href = "page3";
        });

        $('.addToBasketBtn').click(function(){
          $('#searchBy').val('');
          $('#addToBasket').val($(this).attr('data'));
          $('#searchForm').submit();
        });

        document.getElementById('logo').onclick = function(){location.href='page2';};
      });
    </script>
  </body>
</html>
