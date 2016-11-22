<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database
  Due date: Nov 23 2016
-->
<?php
  $HOSTNAME = 'localhost';
  $DATABASE = 'cheapbooks';
  $USERNAME = 'root';
  $PASSWORD = '';

  $CONNECTION_STRING = 'mysql:host='.$HOSTNAME.':3306;dbname='.$DATABASE;

  $errorMessage = '';

  if(isset($_POST['username']) && isset($_POST['password'])){

     $username = $_POST['username'];
     $validUser = false;

     try {
       $dbh = new PDO($CONNECTION_STRING, $USERNAME, $PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

       $stmt = $dbh->prepare('SELECT password FROM customer WHERE username = :usrname');
       $stmt->bindParam(':usrname', $username);

       if($stmt->execute()){

         $row = $stmt->fetch();

         if($row['password'] == md5($_POST['password']))
          $validUser = true;

         echo $validUser;
         if($validUser){
           session_start();

           $_SESSION['username'] = $username;
           header('Location:page2.php');
         } else {
           $errorMessage = 'Invalid User name or Password';
         }
       }
     } catch (Exception $e) {

     }
   } else {
      session_start();
      session_unset();
      session_destroy();
   }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cheapbooks Login</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
  		<div id="header">
  			<div id="logoContainer">
  				<span id="logo">CheapBooks</span>
  			</div>
  		</div>
  		<div id="container">
  			<div style="" id="loginContainer">
          <form id="loginForm" action="page1.php" method="post">
            <div id="loginFormHeader">Login</div>
    				<div class="login-input-div"">Enter your User name</div>
    				<div class="login-input-div"><input type="text" name="username" id="username"/></div>
    				<div class="login-input-div">Enter your Password</div>
    				<div class="login-input-div"><input type="password" name="password" id="passwd"/></div>
    				<div id="loginBtnDiv">
              <input type="submit" id="loginBtn" value="Login"/>
            </div>
          </form>
          <div id="newUserRegisterBtnDiv">
              <input type="button" id="newUserRegisterBtn" value="New users must register here"/>
            </div>
          <div id="errorMessageDiv"><?php echo $errorMessage;?></div>
  			</div>
  		</div>
  		<div id="footer"></div>
	 </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script type="text/javascript">
   $(document).ready(function(){
     <?php
      if($errorMessage != '')
        echo 'document.getElementById("errorMessageDiv").style="display:block";';
     ?>

     $('#newUserRegisterBtn').click(function(){
        location.href = "page4.php";
     });
     
     $('#loginForm').submit(function(e){
        var usernameFld = $('#username').val();
        var passwordFld = $('#passwd').val();

        if(usernameFld === ''){
          alert('Username cannot be empty.');
          e.preventDefault();
          return;
        }

        if(passwordFld === ''){
          alert('Password cannot be empty.');
          e.preventDefault();
          return;
        }
     });
   });
   </script>
  </body>
</html>
