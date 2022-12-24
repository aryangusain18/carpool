<?php

//session_start();
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: registration.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
$em = $_POST['ee'];
$pa = $_POST['pp'];


$servername = "localhost";
$username = "root";
$password = "";
$database = "rental";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

$sql = "SELECT * From users WHERE email='$em' AND password='$pa'";

$pk =mysqli_query($conn,$sql);
$count = mysqli_num_rows ($pk);

if ($count==1)
{
  //................STARTING THE SESSION...........................
   session_start();
   $_SESSION["username"] = $em;
   $_SESSION["loggedin"] = true;

   //Redirect user to main site
      header ("location:registration.php");
}
else
{echo '<div class="alert alert-danger" role="alert">
  <strong>SORRY!</strong> The username or password enterred by you is incorrect
</div>';
 
}
}
?>

<html>
<head>
<title>Signup/Login</title> 
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<title>Car</title>
<!-- <link rel="stylesheet" href="styleregister.css">-->

<style>
  body{
    background-image: url("back.jpg")
     }
  .login{
    height: 220px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 70%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
  }

  .login h3{
    
    top: 10%;
  font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
  }
  .content .par{
    border:30px;
    padding-left: 20px;
    padding-bottom: 25px;
    font-family: Arial;
    letter-spacing: 1.2px;
    line-height: 30px;
    
}

.content h1{
  border:30px;
    font-family: 'Times New Roman';
    font-size: 50px;
    padding-left: 20px;
    margin-top: 9%;
    letter-spacing: 2px;
}

</style>

</head>


<!--....................BODY TAG STARTS-->

<body>
  <!--navigation bar bootstrap-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">RideX</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
 
  <li class="nav-item">
    <a class="nav-link" href="#">Welcome to RideX.Register or login to continue</a>
  </li>
 </ul>
</div>
</nav>

<div class="content">
<h1>RideX </h1>
 <p class="par">PROJECT BY: Aryan Gusain<br> PUT YOUR CAR UP FOR SHARING<br>BOOK A CAR</p>

<!--login-->
<div class="login">
<h3 class="h3">Login</h3>
<form action="login.php"method="POST">
  
<input type="text"placeholder="email"name="ee" required>

<input type="password"placeholder="password"name="pp" required>

<input type="submit"value="login">

</form>

<form action="signup.php"method="GET">
  <input type="submit" value="Sign Up if not a user";>
</form>
  
</div>

</div>


</body>
</html>


