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
    <style>
      body {
        padding-top: 50px;
        padding-bottom: 20px;
      }

      .jumbotron {
          padding-bottom: 90px;
      }

      .col-md-3 {
        width: 20%;
      }

      .col-md-3 h2{
        font-size: 28px;
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
            <li class="active"><a href=".">Home</a></li>
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

    <div class="jumbotron">
     <div class="container">
      <h1>Welcome to Assignment 3</h1>
      <p>
        This is the first assignment for <b>Sai Kumar Manakan</b> for CS 5335
      </p>
     </div>
    </div>
    <div class="container">
      <div class="rows">
        <div class="col-md-3">
          <h2><span class="glyphicon glyphicon-info-sign"></span> About Us </h2>
          <p>
            What is this all about and other stuff
          </p>
          <p><a class="btn btn-default" href="#" role="button"><span class="glyphicon glyphicon-link"></span> View page </a></p>
        </div>
        <div class="col-md-3">
          <h2><span class="glyphicon glyphicon-list"></span> Artist List </h2>
          <p>
            Displays list of artists names as links
          </p>
          <p><a class="btn btn-default" href="Part01_ArtistsDataList.php" role="button"><span class="glyphicon glyphicon-link"></span> View page </a></p>
        </div>
        <div class="col-md-3">
          <h2><span class="glyphicon glyphicon-user"></span> Single Artist </h2>
          <p>
            Displays information for a single artist
          </p>
          <p><a class="btn btn-default" href="Part02_SingleArtist.php?id=1" role="button"><span class="glyphicon glyphicon-link"></span> View page </a></p>
        </div>
        <div class="col-md-3">
          <h2><span class="glyphicon glyphicon-picture"></span> Single Work </h2>
          <p>
            Displays information for a single work
          </p>
          <p><a class="btn btn-default" href="Part03_SingleWork.php?id=1" role="button"> <span class="glyphicon glyphicon-link"></span> View page </a></p>
        </div>
        <div class="col-md-3">
          <h2><span class="glyphicon glyphicon-search"></span> Search </h2>
          <p>
            Performs work on Artworks table
          </p>
          <p><a class="btn btn-default" href="Part04_Search.php" role="button"><span class="glyphicon glyphicon-link"></span> View page </a></p>
        </div>
      </div>
    </div>
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
