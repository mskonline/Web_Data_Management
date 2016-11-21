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

  session_start();
  session_unset();
  session_destroy();
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
  			<div style="text-align:center; margin-top:130px" id="loginContainer">
          <form class="" action="page2.php" method="post">
            <div style="margin: 10px;font-size: 20px;font-weight: bold;">Login</div>
    				<div style="margin: 10px;">Enter your User name</div>
    				<div style="margin: 10px;"><input type="text" name="username" id="username"/></div>
    				<div style="margin: 10px;">Enter your Password</div>
    				<div style="margin: 10px;"><input type="password" name="password" id="passwd"/></div>
    				<div style="margin: 30px;"><input style="width: 80px;height: 30px;cursor:pointer" type="submit" id="loginBtn" value="Login"/></div>
            <div style="margin: 30px;">
              <input style="width: 188px;height: 30px;cursor:pointer" formaction="page4.php" type="submit" id="registerBtn" value="New users must register here"/>
            </div>
          </form>
  			</div>
  		</div>
  		<div id="footer"></div>
	 </div>
  </body>
</html>
