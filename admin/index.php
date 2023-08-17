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
$sql= "SELECT * FROM places";


//Get All Posts
$result = mysqli_query($db, $sql);

// DELETE
if (isset($_GET['deleteYesBtn'])) {
  $id= $_GET['id'];
  $sqlDelete= "DELETE FROM `places` WHERE id= $id";
  $sql2 = "SELECT * FROM places WHERE id = '$id' ";
  
  
  /*=============Deleting Image file first ==================*/
  $posts= mysqli_query($db, $sql2);
  if ($posts) {
    while ($row = mysqli_fetch_array($posts)) {
       
        $fimg = "images/".$row['fimg'];
        if(!empty($fimg)){
          /* Deliting Image*/
          if (!unlink($fimg)) {
            echo ("<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Failed!</strong> Image Couldn't be deleted.
          </div>");
          }
          else {
              
          }  
        }
  
           
      } 
  }
  
  
  /* ================== Deleting table row==============*/
  $query= mysqli_query($db, $sqlDelete);
  if ($query) {
    // Display confirmation alert and reload the page
    echo "<script>
            if (confirm('Record deleted successfully. Click OK to refresh the page.')) {
                //location.reload();
            }else{
              //location.reload();
            }
        </script>";
} else {
    // Handle delete query error
    echo ("<div class='alert alert-danger alert-dismissible'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error!</strong> Delete query failed.
    </div>");
}
  }


?>

<!DOCTYPE html>
<html>
<?php include 'head.php' ?>
<body>
  <?php include 'sidenav.php' ?>

  <div id="main">
    <div class="header">
      <h2>Adventure Nepal</h2>
      <p>Click on the element below to open the side navigation menu, and push this content to the right.</p>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Admin Dashboard</span>
    </div>
    <?php
    
    while ($row = mysqli_fetch_array($result)) {
      $name= $row['name'];
      $desc= $row['description'];
      $id=$row['id'];

      echo"
      <div class='card w-100'>
      <div class='card-body'>
        <img class='rounded float-left' src='images/".$row['fimg']."' alt='Card image cap' onerror=this.src='../images/noimg.svg'>
        <h5 class='card-title'>" . $name. "</h5>
        <p class='card-text'>" . $desc . "</p>


        <form method='POST' action='editplace.php' class='forms' >
        <button href='#' class='btn btn-primary'>Edit ".$id."</button>
        <input type = 'hidden' name = 'id' value =' ".$id."' />
        </form>

        <form method='GET' action='' class='forms' >
        <button href='#' class='btn btn-danger'type='submit' name = 'deleteYesBtn' >Delete ".$id."</button>
        <input type = 'hidden' name = 'id' value =' ".$id."' />
        </form>   
        
      </div>
    </div>";

    
    
    }
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