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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Assignment 3</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="./">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Pages <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Part01_ArtistsDataList.php">Artists Data List (Part 1)</a></li>
                <li><a href="#">Single Artist (Part 2)</a></li>
                <li><a href="#">Single Work (Part 3)</a></li>
                <li><a href="#">Search (Part 4)</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <label for="searchPaintings" style="color:#9d9d9d;padding-right:5px;">Sai Kumar Manakan </label>
              <input type="text" id="searchPaintings" placeholder="Search Paintings" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <?php
      $titleSet = isset($_GET['title']);
      $descriptionSet = isset($_GET['description']);
      $showAll = isset($_GET['show']);

      $anySet = $titleSet || $descriptionSet || $showAll;
     ?>
    <div class="container">
      <h2>Search</h2>

      <form class="" action="Part04_Search.php" method="get">
        <div class="form-group">
          <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" <?php if($titleSet) echo 'checked'; ?>>
              Filter by Title:
            </label>
          </div>
          <?php
            if($titleSet){
              echo '<input type="text" class="form-control" placeholder="Text input" value="'.$_GET['title'].'" />';
            } else {
              echo '<input type="text" class="form-control hidden" placeholder="Text input">';
            }
           ?>
        </div>
        <div class="form-group">
          <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" <?php if($descriptionSet) echo 'checked'; ?>>
              Filter by Description:
            </label>
          </div>
          <?php
            if($descriptionSet){
              echo '<input type="text" class="form-control" placeholder="Text input" value="'.$_GET['description'].'" />';
            } else {
              echo '<input type="text" class="form-control hidden" placeholder="Text input">';
            }
           ?>
        </div>
        <div class="form-group">
          <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
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
                echo '<h4><a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >'.$row['Title'].'</a></h4>';
                $highlightText = preg_replace('/('.$_GET['description'].')/i', '<mark>$1</mark>', $row['Description']);
                echo '<p>'.$highlightText.'</p>';
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

    </script>
  </body>
</html>
