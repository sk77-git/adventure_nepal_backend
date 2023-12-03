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
    $desc = $_POST['description'];
    $desc = trim($desc);

    //$html = $_POST['html'];
    $lat = floatval($_POST['lat']);
    $long = floatval($_POST['long']);
    $categories = isset($_POST['categories']) ? json_encode($_POST['categories']) : '[]';
    $thumbnail = $_POST['thumbnail'];
    $weathers = isset($_POST['weathers']) ? json_encode($_POST['weathers']) : '[]';

    $sql = "INSERT INTO `places` (`name`, `thumbnail`, `description`, `lat`, `long`, `weathers`, `categories`) VALUES ('$name','$thumbnail','$desc','$lat','$long','$weathers','$categories')";

    if (mysqli_query($db, $sql)) {
        $msg = "Place uploaded successfully";
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
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Write something.." required></textarea>
          
            <label for="lat">Latitude</label>
			<input type="number" id="lat" name="lat" step="any" placeholder="Enter latitude..." required>
			<br>
			<label for="long">Longitude</label>
			<input type="number" id="long" name="long" step="any" placeholder="Enter longitude..." required>
		
			<br>
			<br>
			<br>
            <!-- Categories -->
			<label for="categories">Categories</label>
			<br>
			<?php
				// Fetch categories from the database
				$category_query = mysqli_query($db, "SELECT * FROM categories");
				while ($row = mysqli_fetch_assoc($category_query)) {
					echo '<input type="checkbox" name="categories[]" value="' . $row['category'] . '"> ' . $row['category'] . '<br>';
				}
			?>
			<br>

			<!-- Weathers -->
			<label for="weathers">Weathers</label>
			<br>
			<?php
				// Fetch weathers from the database
				$weather_query = mysqli_query($db, "SELECT * FROM weathers");
				while ($row = mysqli_fetch_assoc($weather_query)) {
					echo '<input type="checkbox" name="weathers[]" value="' . $row['weather'] . '"> ' . $row['weather'] . '<br>';
				}
			?>
			<br>

			<br>
			<br>
            <label for="thumbnail">Thumbnail</label>
            <input type="text" id="thumbnail" name="thumbnail" placeholder="Enter thumbnail URL..." required>
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

    <!-- Include your JavaScript dependencies here -->

</body>
</html>

