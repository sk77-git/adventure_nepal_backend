<?php
    // Create database connection
    $db = mysqli_connect("localhost", "root", "", "blogcms");
    $sql= "SELECT * FROM posts";

    $query= mysqli_query($db, $sql);
    
    while ($row = mysqli_fetch_array($query)) {
    $title= $row['title'];
    $content= $row['content'];
    $content=  substr($content, 0, 200) ." ...";  

    $id= $row['id'];  

      echo"<div class='card w-100'>
      <div class='card-body'>
        <img class='rounded float-left' src='admin/images/".$row['fimg']."' alt='Card image cap' onerror=this.src='assets/noimg.svg'>
        <h5 class='card-title'>" . $title . "</h5>
        <p class='card-text'>" . $content . "</p>
        <form action='readmore.php' method='GET'>
        <input type = 'hidden' name = 'id' value =' ".$id."' />
        <button class='btn btn-primary'  type='submit'>Read More</button>
        </form>
        
        
      </div>
    </div>";
    
    }   
   

    ?>       