<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

// Create database connection
$db = mysqli_connect("localhost", "root", "", "adv_nepal");

$msg = "";

if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $title = trim($title);
    $description = $_POST['description'];
    $description = trim($description);

    $html = $_POST['html'];
    $icon = $_POST['icon'];
    $tags = json_encode($_POST['tags']);
    $cities = json_encode($_POST['cities']);
    $weathers = json_encode($_POST['weathers']);
    $minTemp = floatval($_POST['min_temp']);
    $maxTemp = floatval($_POST['max_temp']);

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "icons/" . $filename;

    if ($filename == "") {
        $sql = "INSERT INTO `activities` (`id`, `created_at`, `updated_at`, `title`, `description`, `html`, `icon`, `tags`, `cities`, `weathers`, `min_temp`, `max_temp`)
        VALUES (NULL, NOW(), NOW(), '$title', '$description', '$html', '', '$tags', '$cities', '$weathers', $minTemp, $maxTemp)";
    } else {
        $sql = "INSERT INTO `activities` (`id`, `created_at`, `updated_at`, `title`, `description`, `html`, `icon`, `tags`, `cities`, `weathers`, `min_temp`, `max_temp`)
        VALUES (NULL, NOW(), NOW(), '$title', '$description', '$html', '$icon', '$tags', '$cities', '$weathers', $minTemp, $maxTemp)";

        // try{
        //     if (move_uploaded_file($tempname, $folder)) {
        //         $msg = "Activity added successfully";
        //     } else {
        //         $msg = "Failed to upload Icon";
        //     }
        // }catch(PDOException $e){
            
        // }
    }

    if (mysqli_query($db, $sql)) {
        $msg = "Activity added successfully";
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
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter title here..." required>
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Write something.." required></textarea>
            <label for="html">HTML Content</label>
            <textarea id="html" name="html" placeholder="Enter HTML content..." required></textarea>
            <label for="icon">Icon</label>
            <input type="text" id="icon" name="icon" placeholder="Enter icon URL..." required>
            <label for="tags">Tags</label>
            <input type="text" id="tags" name="tags" placeholder="Enter tags..." required>
            <label for="cities">Cities</label>
            <input type="text" id="cities" name="cities" placeholder="Enter cities..." required>
            <label for="weathers">Weathers</label>
            <input type="text" id="weathers" name="weathers" placeholder="Enter weathers..." required>
            <label for="min_temp">Min Temperature</label>
            <input type="number" id="min_temp" name="min_temp" placeholder="Enter min temperature..." required>
            <label for="max_temp">Max Temperature</label>
            <input type="number" id="max_temp" name="max_temp" placeholder="Enter max temperature..." required>
            <label for="uploadfile">Select Icon</label>
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
</body>
</html>
