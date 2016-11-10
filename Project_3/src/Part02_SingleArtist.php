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
      .description{
        text-align: justify;
      }

      .artistTable {
        margin-top: 20px;
      }

      .topBox {
        border: solid 1px lightgray;
        /* padding: 20px; */
        width: 22%;
        font-size: 12px;
        margin-left: 23px;
        border-radius: 5px;
      }

      .imgBox {
        border: solid 1px lightgray;
        border-radius: 3px;
        padding: 3px;
        width: 142px;
        margin-left: 43px;
        margin-top: 5px;
        margin-bottom: 12px;
      }

      .linkBox {
        margin-bottom: 12px;
      }

      .buttonBox {
        margin-bottom: 12px;
      }

      .btn{
        font-size: 12px;
        margin-left: 5px;
      }

      .white {
        color: #fff;
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
        if($_SERVER['REQUEST_METHOD'] == "GET"){
          if(isset($_GET['id'])){
            $artistId = $_GET['id'];
            $db = new mysqli('localhost','root','','wdm_project3');
            $sql = "SELECT *  FROM artists WHERE artistid=".$artistId;
            $result =  $db->query($sql);
            $row = $result->fetch_assoc();

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
                      echo '<div class="imgBox">';
                        echo '<img src="./images/art/works/square-medium/'.$row['ImageFileName'].'.jpg" class=" center-block"/>';
                      echo '</div>';
                      echo '<div class="linkBox"><a href="">'.$row['Title'].', '.$row['YearOfWork'].'</a></div>';
                      echo '<div class="buttonBox">';
                        echo '<button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-info-sign white"></span> View</button>';
                        echo '<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-gift white"></span> Wish</button>';
                        echo '<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-shopping-cart white"></span> Cart</button>';
                      echo '</div>';
                  echo '</div>';
                }
                echo '</div>';
              echo '</div>';
              $result->close();
              $db->close();
            } else {
              echo "<h2> No Data found </h2>";
            }
          } else {

          }
        }
      ?>
    </div>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
