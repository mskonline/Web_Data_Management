<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CS 5335 - Assignment 3</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style media="screen">
      body {
        padding-top: 50px;
        padding-bottom: 20px;
      }

      h4 {
        margin-top: 0px;
      }

      p {
        text-align: justify;
      }

      .thumbnailx{
        padding: 0;
        border: none;
      }

      mark{
        background: yellow;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="./">Assignment 3</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="./">Home</a></li>
            <li><a href="About.php">About Us</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Pages <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Part01_ArtistsDataList.php">Artists Data List (Part 1)</a></li>
                <li><a href="Part02_SingleArtist.php?id=1">Single Artist (Part 2)</a></li>
                <li><a href="Part03_SingleWork.php?id=1">Single Work (Part 3)</a></li>
                <li><a href="Part04_Search.php">Search (Part 4)</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <label for="searchPaintings" style="color:#9d9d9d;padding-right:5px;">Sai Kumar Manakan </label>
              <input type="text" id="searchPaintings" placeholder="Search Paintings" class="form-control">
            </div>
            <button id="searchPaintingsBtn" class="btn btn-primary">Search</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="alert alert-danger collapse alert-dismissible" role="alert" id="errorMessageDiag">
        <button type="button" class="close" ><span id="closeBtn" aria-hidden="true">×</span></button>
        <p id="errorMessage"></p>
    </div>
    <?php
      $titleSet = isset($_GET['title']);
      $descriptionSet = isset($_GET['description']);
      $showAll = isset($_GET['show']);

      $anySet = $titleSet || $descriptionSet || $showAll;
     ?>
    <div class="container">
      <h2>Search</h2>

      <div class="well">
        <form class="" id="fitlerForm" action="Part04_Search.php" method="get">
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="filterByTitleRB" value="option1" <?php if($titleSet) echo 'checked'; ?>>
                Filter by Title:
              </label>
            </div>
            <?php
              if($titleSet){
                echo '<input type="text" class="form-control" placeholder="Text input" value="'.$_GET['title'].'" id="filterByTitleInp"/>';
              } else {
                echo '<input type="text" class="form-control" placeholder="Text input" id="filterByTitleInp" style="display:none">';
              }
             ?>
          </div>
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="filterByDescRB" value="option2" <?php if($descriptionSet) echo 'checked'; ?>>
                Filter by Description:
              </label>
            </div>
            <?php
              if($descriptionSet){
                echo '<input type="text" class="form-control" placeholder="Text input" value="'.$_GET['description'].'" id="filterByDescInp"/>';
              } else {
                echo '<input type="text" class="form-control" placeholder="Text input" style="display:none" id="filterByDescInp">';
              }
             ?>
          </div>
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="filterByAll" value="option3">
                No Filter (Show all the artworks)
              </label>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Filter</button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <div class="container">
      <?php
        if($anySet){
          $sql = "SELECT ArtWorkID, Title, Description, ImageFileName from artworks";

          if($titleSet)
            $sql = $sql.' WHERE Title like \'%'.$_GET['title'].'%\'';
          else if($descriptionSet)
            $sql = $sql.' WHERE Description like \'%'.$_GET['description'].'%\'';

          $db = new mysqli('localhost','root','','wdm_project3');
          $db->query("SET NAMES 'utf8'");
          $result =  $db->query($sql);

          //header('Content-type: text/html; charset=utf-8');
          while ($row = $result->fetch_assoc()) {
            echo '<div class="row" style="margin-bottom:8px">';
              echo '<div class="col-md-2">';
                echo '<div class="thumbnailx thumbnail">';
                    echo '<a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >';
                      echo '<img src="./images/art/works/square-medium/'.$row['ImageFileName'].'.jpg" class=" center-block">';
                    echo '</a>';
                echo '</div>';
              echo '</div>';

              echo '<div class="col-md-10">';
                if($titleSet){
                  $highlightText = preg_replace('/('.$_GET['title'].')/i', '<mark>$1</mark>', $row['Title']);
                  echo '<h4><a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >'.$highlightText.'</a></h4>';
                  echo '<p>'.$row['Description'].'</p>';
                } else if ($descriptionSet){
                  echo '<h4><a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >'.$row['Title'].'</a></h4>';
                  $highlightText = preg_replace('/('.$_GET['description'].')/i', '<mark>$1</mark>', $row['Description']);
                  echo '<p>'.$highlightText.'</p>';
                } else {
                  echo '<h4><a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >'.$row['Title'].'</a></h4>';
                  echo '<p>'.$row['Description'].'</p>';
                }

              echo '</div>';
            echo '</div>';
          }
        }
      ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
      var filterByTitleRB = $('#filterByTitleRB');
      var filterByTitleInp = $('#filterByTitleInp');

      var filterByDescRB = $('#filterByDescRB');
      var filterByDescInp = $('#filterByDescInp');

      var filterByAll = $('#filterByAll');

      var form = $('#fitlerForm');

      filterByTitleRB.change(function(){
        if($(this).is(":checked")){
          filterByTitleInp.show();
          filterByDescInp.hide()
        }
      });

      filterByDescRB.change(function(){
        if($(this).is(":checked")){
          filterByTitleInp.hide();
          filterByDescInp.show();
        }
      });

      filterByAll.change(function(){
        if($(this).is(":checked")){
          filterByTitleInp.hide();
          filterByDescInp.hide();
        }
      });

      $('#searchPaintingsBtn').click(function(e){
        e.preventDefault();
        var input = $('#searchPaintings').val();

        if(input == ''){
          $('#errorMessage').html('Please enter an artwork title');
          $('#errorMessageDiag').slideDown('fast',function(){
            $('#closeBtn').click(function(){
              $('#errorMessageDiag').slideUp();
            });
          });
          return;
        }

        location.href = "Part04_Search.php?title=" + input;
      });

      form.submit(function(e){
        e.preventDefault();

        if(filterByTitleRB.is(':checked')){
          var input = filterByTitleInp.val();

          if(input == ''){
            $('#errorMessage').html('Please enter an artwork title');
            $('#errorMessageDiag').slideDown('fast',function(){
              $('#closeBtn').click(function(){
                $('#errorMessageDiag').slideUp();
              });
            });
            return;
          }

          location.href = "Part04_Search.php?title=" + input;
        } else if (filterByDescRB.is(':checked')) {
          var input = filterByDescInp.val();

          if(input == ''){
            $('#errorMessage').html('Please enter an artwork description');
            $('#errorMessageDiag').slideDown('fast',function(){
              $('#closeBtn').click(function(){
                $('#errorMessageDiag').slideUp();
              });
            });
            return;
          }

          location.href = "Part04_Search.php?description=" + input;
        } else if (filterByAll.is(':checked')) {

          location.href = "Part04_Search.php?show=all";
        } else {
          $('#errorMessage').html('Please select a filter option');
          $('#errorMessageDiag').slideDown('fast',function(){
            $('#closeBtn').click(function(){
              $('#errorMessageDiag').slideUp();
            });
          });
          return;
        }
      });
    });
    </script>
  </body>
</html>
