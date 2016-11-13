<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
	Project Name: Database-Driven Web Pages
  Due date: Nov 18 2016
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
            <li><a href="./">Home</a></li>
            <li><a href="About.php">About Us</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Pages <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Part01_ArtistsDataList.php">Artists Data List (Part 1)</a></li>
                <li class="active"><a href="Part02_SingleArtist.php?id=1">Single Artist (Part 2)</a></li>
                <li><a href="Part03_SingleWork.php?id=1">Single Work (Part 3)</a></li>
                <li><a href="Part04_Search.php">Search (Part 4)</a></li>
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
      <?php
        $row = NULL;
        if($_SERVER['REQUEST_METHOD'] == "GET"){
          if(isset($_GET['id'])){
            $artistId = $_GET['id'];
            $db = new mysqli('localhost','root','','wdm_project3');
            $db->query("SET NAMES 'utf8'");
            $sql = "SELECT *  FROM artists WHERE artistid=".$artistId;

            $result =  $db->query($sql);
            $row = $result->fetch_assoc();
            header('Content-type: text/html; charset=utf-8');

            if(count($row) > 0){
              $artistName = $row['FirstName'].' '.$row['LastName'];
              echo '<h2 style="margin-left:12px;">'.$artistName.'</h2>';
              echo '<div class="container">';
                echo '<div class="row">';

                  echo '<div class="col-md-4">';
                    echo '<img src="./images/art/artists/medium/'.$row['ArtistID'].'.jpg" />';
                  echo '</div>'; // col-md-4

                  echo '<div class="col-md-5">';
                    echo '<p class="description"> '.$row['Details'].'</p>';
                    echo '<button type="button" style="color:#428bca" class="btn btn-default">&hearts; Add to Favorites List</button>';
                    echo '<table class="table table-hover table-bordered artistTable">';
                      echo '<thead>';
                        echo '<tr>';
                          echo '<th style="height:45px;" class="active" colspan="2"> Artist Details </th>';
                        echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                        echo '<tr>';
                          echo '<th> Date : </th>';
                          echo '<td> '.$row['YearOfBirth'].' - '.$row['YearOfDeath'].' </td>';
                        echo '</tr>';
                        echo '<tr>';
                          echo '<th> Nationality : </th>';
                          echo '<td> '.$row['Nationality'].' </td>';
                        echo '</tr>';
                        echo '<tr>';
                          echo '<th> More Info : </th>';
                          echo '<td> <a target="_blank" href='.$row['ArtistLink'].'>'.$row['ArtistLink'].'</a></td>';
                        echo '</tr>';
                      echo '</tbody>';
                    echo '</table>'; // Table
                  echo '</div>'; // col-md-6

                echo '</div>'; // rows
              echo '</div>';
              $result->close();

              $sql = "SELECT * FROM artworks WHERE artistid=".$artistId;
              $result =  $db->query($sql);

              echo '<div class="container">';
                echo '<h3> Art by '.$artistName.' </h3>';
                echo '<div class="row">';
                while($row = $result->fetch_assoc()) {
                  echo '<div class="text-center col-md-4 topBox">';
                      echo '<div class="thumbnail center-block" style="width:142px">';
                        echo '<a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >';
                          echo '<img src="./images/art/works/square-medium/'.$row['ImageFileName'].'.jpg" class="img-handle">';
                        echo '</a>';
                      echo '</div>';
                      echo '<div class="linkBox"><a href="Part03_SingleWork.php?id='.$row['ArtWorkID'].'" >'.$row['Title'].', '.$row['YearOfWork'].'</a></div>';
                      echo '<div class="buttonBox">';
                        echo '<button type="button" onclick="location.href=\'Part03_SingleWork.php?id='.$row['ArtWorkID'].'\'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-info-sign white"></span> View</button>';
                        echo '<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-gift white"></span> Wish</button>';
                        echo '<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-shopping-cart icon-flipped white"></span> Cart</button>';
                      echo '</div>';
                  echo '</div>';
                }
                echo '</div>';
              echo '</div>';
              $result->close();
              $db->close();
            } else {
              if (headers_sent() === false)
              {
                  header('Location: Error.php');
                  die();
              }
            }
          } else {
            if (headers_sent() === false)
            {
                header('Location: Error.php');
                die();
            }
          }
        }
      ?>
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
