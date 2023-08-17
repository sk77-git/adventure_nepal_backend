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
    $id= $_POST['id'];


    //Get Post details
    $sql = "SELECT * FROM places WHERE id = '$id' ";
    $posts= mysqli_query($db, $sql);
    if ($posts) {
        while ($row = mysqli_fetch_array($posts)) {
            $title= $row['name'];
            $content= $row['description'];
            // $fimg = "images/".$row['fimg'];
        } 
    }


    //Update post 
    if ( isset( $_POST['update']) ) {

        $newTitle= $_POST['name'];
        $newTitle = trim($newTitle);
        $newContent= $_POST['description'];
        $newContent = trim($newContent);

        $newFilename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "images/".$newFilename;
        $sql2 = "UPDATE places SET name='$newTitle', description= '$newContent', fimg= '$folder' WHERE id='$id'";

      
        if(mysqli_query($db, $sql2)){
            if ( move_uploaded_file( $tempname, $folder ) ) {
                $msg = "Article Updated successfully";
            } else{
                $msg = "Failed to update Image";
            }
        }else{
            $msg="Query Not Executed";
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
            <h2>The Hello News Admin Panel</h2>
            <p>Click on the element below to open the side navigation menu, and push this content to the right.</p>
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Admin Dashboard</span>
        </div>

        <div class="container">
       <h2><?php if ( isset( $_POST['update']) ) {echo $msg;} ?></h2>
        <form method="POST" action="editpost.php" enctype="multipart/form-data">
            <label for="name">Title</label>
            <input type="text" id="name" name="name" value="<?php echo $title ?>" required>

            <label for="description">Description</label>
            <input type ="text" id="description" name="dedescription"  value="<?php echo $content ?>"  required>
            <input type="hidden" name="postid" value="<?php echo $id ?>" >

            <!-- Chnaging text area for desc to input text works-->

            <label for="uploadfile"  >Select featured Image</label>
            <input type="file" name="uploadfile" value="" id="file-ip-1"
                accept="image/*" onchange="showPreview(event)";/>
            <p><img id="outputImg" src="<?php echo $fimg ?>" onerror=this.src="../images/noimg.svg" /></p>


            <input type="submit" name="update" >
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

        /*CK Editor*/
        //CKEDITOR.replace( 'desc' );


        function showPreview(event){
          if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("outputImg");
            preview.src = src;
            preview.style.display = "block";
          }
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