<?php
    // Create database connection
    $db = mysqli_connect("localhost", "root", "", "blogcms");
    $sql= "SELECT * FROM ads";

    $query= mysqli_query($db, $sql);
    
    while ($row = mysqli_fetch_array($query)) {
    $title= $row['ad_title'];
    $content= $row['ad_desc'];
    $img= "admin/images/".$row['ad_img'];
    $content=  substr($content, 0, 100) ." ...";  

    $id= $row['id'];  

      echo"<div class='card' style='width: 18rem;'>
      <img class='card-img-top ' style='width: 18rem;' src='".$img."' alt='Card image cap'>
      <div class='card-body'>
        <h5 class='card-title'>".$title."</h5>
        <p class='card-text'>".$content."</p>
        <a href='#' class='btn btn-primary'>Visit Site</a>
      </div>
    </div>";
    
    }   
   

    ?>       