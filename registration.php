<?php
session_start();
  //You cant simply go to the main sie.If you try to go u will be redirected to login
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

    <title>Car</title>
    <link rel="stylesheet" href="styleregister.css">
   <!-- <link rel="stylesheet" href="styleregister.css">-->
  </head>



  <body>
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
        <a class="nav-link" href="#">Register a ride</a>

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


<?php
    //fields are required to submit
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
       

      // Submit these to a database
        //connecting..................................................................
        // Connecting to the Database
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

//.................................................................connect over...

//........DATABASE INSERTION...............................
$name=$_POST['name'];
$phone=$_POST['phone'];
 $car = $_POST['car'];
 $from = $_POST['from'];
 $destination = $_POST['destination'];
 $time=$_POST['time'];
 $sql = "INSERT INTO carpool (name1,phone1,car1,from1,destination1,time1)
 VALUES ('$name','$phone','$car','$from','$destination','$time')";
 if (mysqli_query($conn, $sql)) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your details has been submitted successfully!Wait for someone to contact you
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>';
 } else {
    echo "Error: " . $sql . ":-" . mysqli_error($conn);
 }
mysqli_close($conn);

    }

    
?>


  <div class="container mt-3">
    <div class="title">Registration</div>
    <div class="content">
      <form action="registration.php" method="POST">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" placeholder="Enter your name"name="name" required>
          </div>
          <div class="input-box">
            <label class="details" for="phone">Phone number:</label>
             <input type="tel" id="phone" name="phone" placeholder="123-435-4678" pattern="[0-9]{10}" required>
​       
            
          </div>
          <div class="input-box">
            <span class="details">Car</span>
            <input type="text" placeholder="Enter the car name"name="car" required>
          </div>
          <div class="input-box">
            <span class="details">FROM</span>
            <input type="text" placeholder="FROM" name="from"required>
          </div>
          <div class="input-box">
            <span class="details">Destination</span>
            <input type="text" placeholder="Enter your destination" name="destination"required>
          </div>
          <div class="input-box">
          <span class="details">Time</span>

          <input type="datetime-local" id="timedddddd" name="time" required>
          
          </div>
        </div>
       
        <div class="button">
          <input type="submit" value="Register your car">
        </div>
      </form>
    </div>
  </div>

</body>
</html>

