<?php

    // Create database connection
    $db = mysqli_connect("localhost", "root", "", "blogcms");

    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = '$id' ";

    $posts= mysqli_query($db, $sql);

    while ($row = mysqli_fetch_array($posts)) {
    $title= $row['title'];
    $content= $row['content'];
    $fimg = "admin/images/".$row['fimg'];
    $updated= $row['date_updated'];

    } 

    

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
  <div class="wrapper border">
        <!-- Child 1 Header -->
        <header class="header border">
        <?php include 'navbar.php'?>
        </header>
        <!-- Child 2 Main -->
        <article class="main border">
            <h3>Article in Detail</h3>
            <div class="dropdown-divider"></div>
            <div class="card mb-3">
                <img src="<?php echo $fimg ?>" 
                class="card-img-top" alt="featured image" id="f_img" onerror=this.src='assets/noimg.svg'>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $title ?></h5>
                  <p class="card-text"><?php echo $content ?></p>
                  <p class="card-text"><small class="text-muted">Last updated at <?php echo $updated ?></small></p>
                </div>
              </div>
        </article>
        
        <!-- Child 3 Sidebar-->
        <aside class="aside aside2 border">    
        <h3>Notifications</h3>
        <div class="dropdown-divider">
        </div>
        <?php include 'sidebar.php'?>      
        </aside>

        <!-- Child 4 Footer -->
        <footer class="footer border">
        <?php include 'footer.php'?>
        </footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>