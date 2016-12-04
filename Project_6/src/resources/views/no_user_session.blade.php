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
	<title>No User Session</title>
</head>
<body>
	<h1>Error: No user session available</h1>
    <h3>Redirecting to login page in <span id="ctx">8</span> seconds...</h3>
    <script>
      var counter = 7;
      function countdown(){
        var elem = document.getElementById("ctx");
        elem.innerHTML = counter--;

        if(counter == 0)
          location.href = "page1";
      }
      setInterval(countdown, 1000);
    </script>
</body>
</html>