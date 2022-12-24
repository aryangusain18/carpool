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

    <title>Details</title>

    <style>
#myTable {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#myTable td, #myTable th {
  border: 1px solid #ddd;
  padding: 8px;
}

#myTable tr:nth-child(even){background-color: #f2f2f2;}

#myTable tr:hover {background-color: #ddd;}

#myTable th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>

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

<div class="container my-4">
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Car owner</th>
      <th scope="col">Phone</th>
      <th scope="col">Car</th>
      <th scope="col">Time</th>
    </tr>
  </thead>
  <tbody>
<?php
    //fields are required to submit
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        

        $namebook = $_POST['namebook'];
        $phonebook = $_POST['phonebook'];
        $frombook = $_POST['frombook'];
        $destinationbook = $_POST['destinationbook'];
        $timebook = $_POST['timebook'];
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your details has been submitted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>';
      // Submit these to a database
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
      
    $sql = "SELECT * FROM carpool WHERE (from1='$frombook' AND destination1='$destinationbook'  AND time1 >='$timebook'  ) ";
      $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) 
      {
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr>
        <th scope='row'>". $row['name1'] . "</th>
        <td>". $row['phone1'] . "</td>
        <td>". $row['car1'] . "</td>
         <td>" .$row['time1']."</td>
      </tr>";}
    } 
    else{
      
      echo '<div class="alert alert-danger" role="alert">
      <strong>SORRY!</strong> No ride could be found
    </div>';
echo'<p style="color:blue; font-size: 30px;>NO RIDE FOUND.</p>';
    }
    }

    
?>
  </tbody>
</table>
</div>
<hr>
  </body>
  </html>