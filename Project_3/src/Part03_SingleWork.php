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

    .optButton{
      color: #428bca;
      font-weight: bold;
      margin-right: 10px;
    }

    #artWorktTable{
      margin-top: 20px;
      border: 1px solid #ddd;
    }

    #artWorktTable th {
      font-weight: bold;
      border-top:1px solid #ddd;
    }

    #artWorktTable td {
      border-top:1px solid #ddd;
    }

    #salesTable td, #salesTable th {
      border: none;
    }

    #salesTable th{
      color: #428bca;
    }

    #salesTable.table {
        border: 2px solid #d9edf7;
        border-collapse:inherit;
    }

    .icon-flipped{
      transform: scaleX(-1);
      -moz-transform: scaleX(-1);
      -webkit-transform: scaleX(-1);
      -ms-transform: scaleX(-1);
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

  <div class="container">
    <?php
    $row = NULL;
    $artistName = "";
    $imgTitle = "";
    $largeImageSrc = "";

    if($_SERVER['REQUEST_METHOD'] == "GET"){
      if(isset($_GET['id'])){
        $artworkId = $_GET['id'];
        $db = new mysqli('localhost','root','','wdm_project3');
        $db->query("SET NAMES 'utf8'");

        $sql = "SELECT *  FROM artworks WHERE artworkid=".$artworkId;
        $genreSQL = "SELECT g.GenreName FROM genres g, artworkgenres ag WHERE ag.ArtWorkID = $artworkId AND ag.GenreID = g.GenreID";
        $subjectsSQL = "SELECT sb.SubjectName FROM subjects sb, artworksubjects asb WHERE asb.ArtWorkID = $artworkId AND asb.SubjectID = sb.SubjectId";
        $ordersSQL = "SELECT ord.DateCreated FROM orders ord, orderdetails orddt WHERE orddt.ArtWorkID = $artworkId AND orddt.OrderID = ord.OrderID";

        $result =  $db->query($sql);
        $row = $result->fetch_assoc();
        header('Content-type: text/html; charset=utf-8');

        if(count($row) > 0) {
          $artistNameSQL = "SELECT FirstName, LastName FROM artists WHERE ArtistID=".$row['ArtistID'];
          $result = $db->query($artistNameSQL);
          $data = $result->fetch_assoc();
          $artistName = $data['FirstName'].' '.$data['LastName'];

          echo '<h2>'.$row['Title'].'</h2>';
          echo '<h6>By <a href="Part02_SingleArtist.php?id='.$row['ArtistID'].'">'.$artistName.'</a></h6>';
          echo '<div class="row">';

            echo '<div class="col-md-4">';
              echo '<img src="./images/art/works/medium/'.$row['ImageFileName'].'.jpg" class="" data-toggle="modal" data-target="#myModal"/>';
            echo '</div>'; // col-md-2=4

            echo '<div class="col-md-6">';
              echo '<p class="description"> '.$row['Description'].'</p>';
              echo '<p style="color:red;font-size:16px;font-weight:bold;">$'.sprintf("%.2f", $row['Cost']).'</p>';
              echo '<button type="button" class="btn btn-default optButton"><span class="glyphicon glyphicon-gift"></span> Add to Wish List</button>';
              echo '<button type="button" class="btn btn-default optButton"><span class="glyphicon glyphicon-shopping-cart icon-flipped"></span> Add to Shopping cart</button>';
              echo '<table class="table table-hover" id="artWorktTable">';
                echo '<thead>';
                echo '<tr>';
                echo '<th style="height:45px;font-weight:normal;" class="active" colspan="2"> Product Details </th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                echo '<tr>';
                echo '<th> Date: </th>';
                echo '<td> '.$row['YearOfWork'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Medium: </th>';
                echo '<td> '.$row['Medium'].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Dimensions: </th>';
                echo '<td> '.$row['Width'].'cm X '.$row['Height'].'cm </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th> Home: </th>';
                echo '<td> '.$row['OriginalHome'].' </td>';
                echo '</tr>';
                echo '<tr>';
                  echo '<th> Genres: </th>';
                  $res = $db->query($genreSQL);
                  echo '<td>';
                    while ($data = $res->fetch_assoc()) {
                      echo '<a href="#">'.$data['GenreName'].'</a><br>';
                    }
                  echo '</td>';
                  $res->close();
                echo '</tr>';
                echo '<tr>';
                  echo '<th> Subjects : </th>';
                  $res = $db->query($subjectsSQL);
                  echo '<td>';
                    while ($data = $res->fetch_assoc()) {
                      echo '<a href="#">'.$data['SubjectName'].'</a><br>';
                    }
                  echo '</td>';
                  $res->close();
                  echo '</tr>';
                echo '</tbody>';
              echo '</table>'; // Table
            echo '</div>'; // col-md-6

            $res = $db->query($ordersSQL);

            echo '<div class="col-md-2">';
              echo '<table class="table" id="salesTable">';
                echo '<thead>';
                  echo '<tr>';
                    echo '<th style="height:38px;border:none;" class="info" colspan="2"> Sales </th>';
                  echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($data = $res->fetch_assoc()) {
                  echo '<tr>';
                  $dateFromDB = strtotime($data['DateCreated']);
                  $myFormatForView = date("m/d/y", $dateFromDB);
                  echo '<td><a href="#">'.$myFormatForView.'</a></td>';
                  echo '</tr>';
                }

                $res->close();
                echo '</tbody>';
              echo '</table>'; // Table
            echo '</div>'; // col-md-2

          echo '</div>'; // row

          $imgTitle = $row['Title'].' ('.$row['YearOfWork'].') by '.$artistName;
          $largeImageSrc = './images/art/works/medium/'.$row['ImageFileName'].'.jpg';
        } else {
          echo '<h1>No data found.</h1>';
        }

        $result->close();
        $db->close();
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
  <script type="text/javascript">
    $(document).ready(function(){
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
    });
  </script>
</body>
</html>
