<?php
session_start();

  if(!isset($_SESSION['loggedin']) )
  {
      header("location: login.php");
  }

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Get and post!</title>
    
   <!-- <link rel="stylesheet" href="styleregister.css">-->
   <style>

  body{
    background-image: url("back.jpg")
     }
    .input-box{
      padding:5px;
    }
    .title{
      font-style: italic;
      font-size: 25px;
    font-weight: 500;
    
    }
    .details{
      display: flex;
  font-weight: 500;
  margin-bottom: 2px;
    }
    .container{
  margin-top: 40px;
  position: relative;
  margin-left: 40px;
  max-width: 500px;
  width: 100%;
  background-color: rgba(220,155,105,100.13) ;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
input{
  height: 30px;
  width: 80%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  border-bottom-width: 2px;
  transition: all 0.3s ease;
}

   </style>
  </head>
  

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">RideX</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
     
      <li class="nav-item">
        <a class="nav-link" href="booking.php">Book a ride</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registration.php">Register a ride</a>
      </li>
     
     <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['username']?></a>
      </li>
    </ul>
   
  </div>
</nav>

<div class="container mt-3"  >
<div class="title">Please enter your details</div>
    <div class="content">
     <form action="details.php" method="POST">
    <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" placeholder="Enter your name" name="namebook"required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="tel" id="phone"  placeholder="Enter your number" name="phonebook" pattern="[0-9]{10}" required>
​        </div>
          
          <div class="input-box">
            <span class="details">FROM</span>
            <input type="text" placeholder="FROM" name="frombook"required>
          </div>
          <div class="input-box">
            <span class="details">DESTINATION</span>
            <input type="text" placeholder="Destination" name="destinationbook" required>
          </div>
          <div class="input-box">
          <span class="details">TIME</span>
          <input type="datetime-local" id="timedddddd" name="timebook" required>
          </div>
          <button style="color:white;margin:auto;background:linear-gradient(135deg, #71b7e6, #9b59b6);padding:20px;
 " type="submit" class="btn btn-primary">Submit</button>
          
</form>
</div>
</div>
     

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>