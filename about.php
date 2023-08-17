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
        <h3>About Us</h3>
        <p class="card-text" style="font-size:18px">We are The Boring News Pvt Ltd. Although the name is Boring News, we provide high quality geniune and latest news articles. We also publish notices and advertiements.</p>

        <p class="card-text" style="font-size:18px">We are dedicated at providing you real news unlike some fake news websites which provide only irrevalant and fake news.</p>
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