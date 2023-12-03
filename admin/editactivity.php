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

    //Get Place details
    $sql = "SELECT * FROM activities WHERE id = '$id' ";
    $activities= mysqli_query($db, $sql);
    if ($activities) {
        while ($row = mysqli_fetch_array($activities)) {
            $title= $row['name'];
            $content= $row['description'];
       
			$thumbnail= $row['thumbnail'];
			$categories = $row['categories'];
			$selectedCategories = json_decode($categories); // Assuming $categories contains JSON-encoded category names
			$weathers= $row['weathers'];
        } 
    }
    // Update post
	if (isset($_POST['update'])) {
		$newId = $_POST['id'];
		$newTitle = $_POST['name'];
		$newTitle = trim($newTitle);
		$newContent = $_POST['description'];
		$newContent = trim($newContent);

	
		$newThumbnail = $_POST['thumbnail'];
		$newCategories = isset($_POST['categories']) ? json_encode($_POST['categories']) : '[]';
		$newWeathers = isset($_POST['weathers']) ? json_encode($_POST['weathers']) : '[]';

		$sql = "UPDATE activities SET name='$newTitle', description='$newContent', thumbnail='$newThumbnail', categories='$newCategories', weathers='$newWeathers' WHERE id='$newId'";

		if (mysqli_query($db, $sql)) {
			$msg = "Activity Updated successfully";
			// Redirect back to the same page with the id parameter using POST
			echo "<form id='redirectForm' method='post' action=''>
                <input type='hidden' name='id' value='$newId'>
              </form>
              <script>
                document.getElementById('redirectForm').submit();
              </script>";
		} else {
			$msg = "Query Not Executed: " . mysqli_error($db);
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
       <h2><?php if ( isset( $_POST['update']) ) {echo $msg;} ?></h2>
        <form method="POST" action="editactivity.php" enctype="multipart/form-data">
    <label for="name">Title</label>
    <input type="text" id="name" name="name" value="<?php echo $title ?>" required>

    <label for="description">Description</label>
    <input type="text" id="description" name="description" value="<?php echo $content ?>" required>
	

	<br>
    <label for="thumbnail">Thumbnail</label>
    <input type="text" id="thumbnail" name="thumbnail" value="<?php echo $thumbnail ?>" required>
	<br>
	<br>
   <label for="categories">Categories</label>
	<br>
	<?php
	// Fetch all categories
	$allCategoriesQuery = mysqli_query($db, "SELECT * FROM categories");
	$selectedCategories = json_decode($categories); // Assuming $categories contains JSON-encoded category names

	while ($row = mysqli_fetch_assoc($allCategoriesQuery)) {
		$categoryId = $row['id'];
		$categoryName = $row['category'];
		$checked = in_array($categoryName, $selectedCategories) ? 'checked' : '';

		echo '<input type="checkbox" name="categories[]" value="' . $categoryName . '" ' . $checked . '> ' . $categoryName . '<br>';
	}
	?>
	<br>
	<p>
	<br>
	<br>
	 <label for="weathers">Weathers</label>
	<br>
	<?php
	// Fetch all categories
	$allWeathersQuery = mysqli_query($db, "SELECT * FROM weathers");
	$selectedWeathers = json_decode($weathers); // Assuming $categories contains JSON-encoded category names

	while ($row = mysqli_fetch_assoc($allWeathersQuery)) {
		$weatherId = $row['id'];
		$weatherName = $row['weather'];
		$checked = in_array($weatherName, $selectedWeathers) ? 'checked' : '';

		echo '<input type="checkbox" name="weathers[]" value="' . $weatherName . '" ' . $checked . '> ' . $weatherName . '<br>';
	}
	?>
	<br>


    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="update">
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