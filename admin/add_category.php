<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Create database connection
$db = mysqli_connect("localhost", "root", "", "adv_nepal");

$msg = "";

if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $name = trim($name);


    $sql = "INSERT INTO `categories`(`category`) VALUES ('$name')";

    if (mysqli_query($db, $sql)) {
        $msg = "Category created successfully";
    } else {
        $msg = "Query Not Executed";
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

        <div class="container">
        <h2><?php echo $msg; ?></h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter name here..." required>
          
            <input type="submit" name="upload">
        </form>
        </div>
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

        function showPreview(event){
          if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("outputImg");
            preview.src = src;
            preview.style.display = "block";
          }
        }

    </script>

</body>
</html>

