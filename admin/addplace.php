<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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

    $html = $_POST['html'];
    $lat = floatval($_POST['lat']);
    $long = floatval($_POST['long']);
    $tags = json_encode($_POST['tags']);
    $nearbyPlaces = json_encode($_POST['nearbyPlaces']);
    $thumbnail = $_POST['thumbnail'];

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "images/" . $filename;


    // $tagsArray = explode(',', $tags);
    // $tagsJson = json_encode($tagsArray);
    $tagsJson= "[$tags]";
    $nearbyPlacesJson="[$nearbyPlaces]";


    // $nearbyPlacesArray = explode(',', $nearbyPlaces);
    // $nearbyPlacesJson = json_encode($nearbyPlacesArray);

    if ($filename == "") {
        $sql = "INSERT INTO `places` (`id`, `name`, `images`, `thumbnail`, `description`, `html`, `lat`, `lang`, `tags`, `nearby_places`)
        VALUES (NULL, '$name', '[]', '$thumbnail', '$desc', '$html', $lat, $long, '$tags', '$nearbyPlaces')";
    } else {
        $sql = "INSERT INTO `places` (`id`, `name`, `images`, `thumbnail`, `description`, `html`, `lat`, `lang`, `tags`, `nearby_places`)
        VALUES (NULL, '$name', '$images', '$thumbnail', '$desc', '$html', $lat, $long, '$tagsJson', '$nearbyPlacesJson')";

        if (move_uploaded_file($tempname, $folder)) {
            $msg = "Place uploaded successfully";
        } else {
            $msg = "Failed to upload Image";
        }
    }

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
            <label for="html">HTML Content</label>
            <textarea id="html" name="html" placeholder="Enter HTML content..." required></textarea>
            <label for="lat">Latitude</label>
            <input type="number" id="lat" name="lat" placeholder="Enter latitude..." required>
            <label for="long">Longitude</label>
            <input type="number" id="long" name="long" placeholder="Enter longitude..." required>
            <label for="tags">Tags</label>
            <input type="text" id="tags" name="tags" placeholder="Enter tags..." required>
            <label for="nearbyPlaces">Nearby Places</label>
            <input type="text" id="nearbyPlaces" name="nearbyPlaces" placeholder="Enter nearby places..." required>
            <label for="images">Images</label>
            <input type="text" id="images" name="images" placeholder="Enter image URLs..." required>
            <label for="thumbnail">Thumbnail</label>
            <input type="text" id="thumbnail" name="thumbnail" placeholder="Enter thumbnail URL..." required>
            <label for="uploadfile">Select featured Image</label>
            <input type="file" name="uploadfile" value="" id="file-ip-1" accept="image/*" onchange="showPreview(event)";/>
            <p><img id="outputImg"/></p>
            <input type="submit" name="upload">
        </form>
        </div>
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
