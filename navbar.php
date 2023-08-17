<nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand" href="#">Hello News</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav mr-auto">
             <li class="nav-item active">
               <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="about.php">About Us</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="contact.php">Contact Us</a>
             </li>
             <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Login
               </a>
               <form action="login.php" method="GET">
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login.php">As Admin</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item disabled" href="login.php">As User</a>
                      </div>
               </form>
             </li>
             <li class="nav-item">
               <a class="nav-link disabled" href="#">Disabled</a>
             </li>
           </ul>
           <form class="form-inline my-2 my-lg-0">
             <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
             <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
           </form>
         </div>
       </nav>