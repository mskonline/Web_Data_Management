<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
    .description{
      text-align: justify;
    }
    .artWorktTable{
      margin-top: 20px;
    }

    .salesTable{

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

  <div class="container">
    <?php
    $row = NULL;
    $imgTitle = "";
    $largeImageSrc = "";

    if($_SERVER['REQUEST_METHOD'] == "GET"){
      if(isset($_GET['id'])){
        $artworkId = $_GET['id'];
        $db = new mysqli('localhost','root','','wdm_project3');
        $db->query("SET NAMES 'utf8'");
        $sql = "SELECT *  FROM artworks WHERE artworkid=".$artworkId;
        $result =  $db->query($sql);
        $row = $result->fetch_assoc();
        header('Content-type: text/html; charset=utf-8');

        if(count($row) > 0) {
          echo '<h2>'.$row['Title'].'</h2>';
          echo '<h6>By <a href=""></a></h6>';

          //echo '<div class="container">';
            echo '<div class="row">';

            echo '<div class="col-md-4">';
              echo '<img src="./images/art/works/medium/'.$row['ImageFileName'].'.jpg" class="" data-toggle="modal" data-target="#myModal"/>';
            echo '</div>';

            echo '<div class="col-md-6">';
              echo '<p class="description"> '.$row['Description'].'</p>';
              echo '<p style="color:red;font-size:16px;font-weight:bold;">$'.sprintf("%.2f", $row['Cost']).'</p>';
              echo '<button type="button" style="color:#428bca;margin-right:10px;" class="btn btn-default">&hearts; Add to Wish List</button>';
              echo '<button type="button" style="color:#428bca" class="btn btn-default">&hearts; Add to Shopping cart</button>';
              echo '<table class="table table-hover table-bordered artWorktTable">';
                echo '<thead>';
                echo '<tr>';
                echo '<th style="height:45px;" class="active" colspan="2"> Product Details </th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                echo '<tr>';
                echo '<th> Date : </th>';
                echo '<td> '.$row['YearOfWork'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Medium : </th>';
                echo '<td> '.$row['Medium'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Dimensions : </th>';
                echo '<td> '.$row['Width'].'cm X '.$row['Height'].'cm </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Home : </th>';
                echo '<td> '.$row['OriginalHome'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Genres : </th>';
                echo '<td> '.$row['Medium'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Subjects : </th>';
                echo '<td> '.$row['Medium'].' </td>';
                echo '</tr>';
                echo '</tbody>';
              echo '</table>'; // Table
            echo '</div>';

            echo '<div class="col-md-2">';
            echo '<table class="table table-hover table-bordered salesTable">';
              echo '<thead>';
              echo '<tr>';
              echo '<th style="height:45px;" class="info" colspan="2"> Sales </th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';
              echo '<tr>';
              echo '<td> 7/7/2016 </td>';
              echo '</tr>';
              echo '</tbody>';
            echo '</table>'; // Table
            echo '</div>';

            echo '</div>';
          //echo '</div>';

          $imgTitle = $row['Title'].' ('.$row['YearOfWork'].') by ';//TODO
          $largeImageSrc = './images/art/works/medium/'.$row['ImageFileName'].'.jpg';
        }
      }
    }
    ?>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $imgTitle; ?></h4>
          </div>
          <div class="modal-body">
            <img src="<?php echo $largeImageSrc;?>" class="center-block" alt="<?php echo $title; ?>" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> <!-- modal -->
  </div><!-- container -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
