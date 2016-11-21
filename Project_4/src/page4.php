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
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CheapBooks</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
        </div>
      </div>
      <div id="container" style="padding-top:30px;">
        <div id="registerContainer">
          <form class="" action="page2.php" method="post">
            <div style="padding-top: 20px;font-size: 20px;font-weight: bold; text-align:center;">Register</div>
            <div style="margin: 10px;">Enter your User name:</div>
            <div style="margin: 10px;"><input class="rInput" type="text" name="username" id="username"/></div>
            <div style="margin: 10px;">Enter your Address:</div>
            <div style="margin: 10px;"><textarea class="rInput" type="text" name="addr" id="addr" rows="5"></textarea></div>
            <div style="margin: 10px;">Enter your Phone Number:</div>
            <div style="margin: 10px;"><input class="rInput" type="text" name="phone" id="phone"/></div>
            <div style="margin: 10px;">Enter your Password:</div>
            <div style="margin: 10px;"><input class="rInput" type="password" name="password" id="passwd"/></div>
            <div style="margin: 10px;">Enter your Password Again:</div>
            <div style="margin: 10px;"><input class="rInput" type="password" name="password2" id="passwd2"/></div>
            <div style="text-align:center; margin-bottom:25px">
              <input style="width: 110px;height: 30px;cursor:pointer;margin-top: 20px;" formaction="page4.php" type="submit" id="registerBtn" value="Register"/>
            </div>
          </form>
        </div>
      </div>
      <div id="footer"></div>
   </div>
  </body>
</html>
