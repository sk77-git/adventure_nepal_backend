<?php error_reporting(0);

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

// Create database connection
$db = mysqli_connect("localhost", "root", "", "adv_nepal");
$sql= "SELECT * FROM admins";


// DELETE
if (isset($_GET['deleteYesBtn'])) {
 
$id= $_GET['userid'];
$sqlDelete= "DELETE FROM `admins` WHERE id= $id";

//$sql2 = "SELECT * FROM posts WHERE id = '$id' ";


/*=============Deleting Image file first ==================*/
// $posts= mysqli_query($db, $sql2);
// if ($posts) {
//   while ($row = mysqli_fetch_array($posts)) {
     
//       $fimg = "images/".$row['fimg'];

//       /* Deliting Image*/
//       if (!unlink($fimg)) {
//         echo ($fimg ."cannot be deleted due to an error");
//     }
//     else {
//         //echo ("$fimg has been deleted");
//     }     
//     } 
// }


/* ================== Deleting table row==============*/
$query= mysqli_query($db, $sqlDelete);
if ($query) {
  echo ("<div class='alert alert-success alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Success!</strong> Deleted.
  </div>");
}
}

/* ===========================*/
$result = mysqli_query($db, $sql);


?>

<!DOCTYPE html>
<html>
<?php include 'head.php' ?>

<style>
table {
    margin: 50px 50px 50px 50px;
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #ffffff;
}
tr:nth-child(odd) {
  background-color: #ffffff;
}
</style>

<body>
  <?php include 'sidenav.php' ?>

  <div id="main">
    <div class="header">
      <h2>The Hello News Admin Panel</h2>
      <p>Click on the element below to open the side navigation menu, and push this content to the right.</p>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Admin Dashboard</span>
    </div>
    <?php

    
    echo("<table class='table table-bordered'>
    <tr>
      <th>Username</th>
      <th>Created Date</th>
      <th>User Type</th>
      <th>Action</th>
    </tr>");
    while ($row = mysqli_fetch_array($result)) {
          
      $username= $row['username'];
      $type= $row['type'];
      $date= $row['created_at'];
      $id= $row['id'];
      echo "
      <tr>
        <td>".$username."</td>
        <td>".$date."</td>
        <td>".$type."</td>
        <td> <form method='GET' action='' class='forms' >
        <button href='#' class='btn btn-danger'type='submit' name = 'deleteYesBtn' >Delete ".$id."</button>
        <input type = 'hidden' name = 'userid' value =' ".$id."' />
        </form> </td>
      </tr>
      ";

    
    
    }
    echo("</table>");
    ?>
  </div>

  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft = "0";
    }
  </script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>