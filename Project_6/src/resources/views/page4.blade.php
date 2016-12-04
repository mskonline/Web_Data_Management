<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with Laravel
  Due date: Dec 5 2016
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="csrf-token" content="<?php echo csrf_token();?>">
    <title>CheapBooks</title>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" media="screen" title="no title">
  </head>
  <body>
    <div id="main">
      <div id="header">
        <div id="logoContainer">
          <span id="logo">CheapBooks</span>
        </div>
        <div id="strip"></div>
      </div>
      <div id="container" class="containerStyle">
        <div id="registerContainer">
          <form id="registerForm" class="" action="page4" method="post">
			{{ csrf_field() }}
            <div id="registerFormHeader" >Register</div>
            <div class="register-input-div">Enter your User name:</div>
            <div class="register-input-div"><input class="rInput" type="text" name="usrname" id="usrname"/></div>
            <div class="register-input-div">Enter your Email:</div>
            <div class="register-input-div"><input class="rInput" type="text" name="email" id="email"/></div>
            <div class="register-input-div">Enter your Address:</div>
            <div class="register-input-div"><textarea class="rInput" type="text" name="addr" id="addr" rows="3"></textarea></div>
            <div class="register-input-div">Enter your Phone Number:</div>
            <div class="register-input-div"><input class="rInput" type="text" name="phone" id="phone"/></div>
            <div class="register-input-div">Enter your Password:</div>
            <div class="register-input-div"><input class="rInput" type="password" name="password" id="passwd"/></div>
            <div class="register-input-div">Enter your Password Again:</div>
            <div class="register-input-div"><input class="rInput" type="password" name="password2" id="passwd2"/></div>
            <div id="registerBtnDiv">
              <input formaction="page4" type="submit" id="registerBtn" value="Register"/>
            </div>
          </form>
        </div>
      </div>
      <div id="footer"></div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){

        $('#logo').click(function(){
          location.href = "page1";
        });

        <?php 
          if($userSaved){
            echo 'setTimeout(function(){alert("User saved successfully. Redirecting to Login page..."); location.href="customer"; }, 500);';
          }
        ?>

        $('#registerForm').submit(function(e){
          var usernameFld = $('#usrname').val();
          var emailFld = $('#email').val();
          var addrFld = $('#addr').val();
          var phoneFld = $('#phone').val();
          var passwdFld = $('#passwd').val();
          var passwd2Fld = $('#passwd2').val();

          if(usernameFld === ''){
            alert('Username cannot be empty.');
            e.preventDefault();
            return;
          }

          if(emailFld === ''){
            alert('Email cannot be empty.');
            e.preventDefault();
            return;
          }

          if(addrFld === ''){
            alert('Address cannot be empty.');
            e.preventDefault();
            return;
          }

          if(phoneFld === ''){
            alert('Phone number cannot be empty.');
            e.preventDefault();
            return;
          }

          if(!$.isNumeric(phoneFld) || phoneFld.length != 10){
            alert('Phone number invalid.');
            e.preventDefault();
            return;
          }

          if(passwdFld === ''){
            alert('Password cannot be empty.');
            e.preventDefault();
            return;
          }

          if(passwd2Fld === ''){
            alert('Password needs to be re-typed.');
            e.preventDefault();
            return;
          }

          if(passwdFld !== passwd2Fld){
            alert('Passwords do not match.');
            e.preventDefault();
            return;
          }
        });
      });
      </script>
   </div>
  </body>
</html>