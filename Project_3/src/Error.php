<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: Database-Driven Web Pages
  Due date: Nov 20 2016
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS 5335 - Assignment 3</title>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="./">Assignment 3</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href=".">Home</a></li>
            <li><a href="About.php">About Us</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Pages <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Part01_ArtistsDataList.php">Artists Data List (Part 1)</a></li>
                <li><a href="Part02_SingleArtist.php?id=19">Single Artist (Part 2)</a></li>
                <li><a href="Part03_SingleWork.php?id=394">Single Work (Part 3)</a></li>
                <li><a href="Part04_Search.php">Advanced Search (Part 4)</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <label for="searchPaintings" style="color:#9d9d9d;padding-right:5px;"><span data-placement="bottom" data-toggle="tooltip" data-original-title="UTA ID - 1001236131">Sai Kumar Manakan</span></label>
              <input type="text" id="searchPaintings" placeholder="Search Paintings" class="form-control">
            </div>
            <button id="searchPaintingsBtn" class="btn btn-primary">Search</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="alert alert-danger collapse alert-dismissible" role="alert" id="errorMessageDiag">
        <button type="button" class="close" id="closeBtn"><span aria-hidden="true">×</span></button>
        <p style="text-align:center"><span class="glyphicon glyphicon-exclamation-sign"></span> <span id="errorMessage"></span></p>
    </div>
    <div class="container">
      <div class="well">
        <h1>Error</h1>
        <h4 style="color:red">Missing or Invalid Query string 'id' parameter.</h4>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $('#searchPaintings').focus(function(){
          $('#errorMessageDiag').slideUp();
        });

        $('#closeBtn').click(function(){
          $('#errorMessageDiag').slideUp();
        });

        $('#searchPaintingsBtn').click(function(e){
          e.preventDefault();
          var input = $('#searchPaintings').val();

          if(input == ''){
            $('#errorMessage').html('Please enter an artwork title');
            $('#errorMessageDiag').slideDown();
            return;
          }

          location.href = "Part04_Search.php?title=" + input;
        });
      });
    </script>
  </body>
</html>
