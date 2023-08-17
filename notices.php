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
    <?php
    
    while ($row = mysqli_fetch_array($result)) {
          
      $title= $row['title'];
      $content= $row['content'];
      $content=  substr($content, 0, 350) ." ...";
      $id=$row['id'];

      echo"
      <div class='card w-100'>
      <div class='card-body'>
        <img class='rounded float-left' src='images/".$row['fimg']."' alt='Card image cap' onerror=this.src='../assets/noimg.svg'>
        <h5 class='card-title'>" . $title. "</h5>
        <p class='card-text'>" . $content . "</p>


        <form method='POST' action='editpost.php' class='forms' >
        <button href='#' class='btn btn-primary'>Edit ".$id."</button>
        <input type = 'hidden' name = 'postid' value =' ".$id."' />
        </form>

        <!-- Button trigger modal -->
        <button type='button' class='btn btn-primary' data-toggle='modal' onclick='' data-target='#exampleModalCenter'>
          Delete ".$id."
        </button>

        <form method='GET' action='' class='forms' >

        <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalCenterTitle'>Delete Post</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                Are you sure to delete post ID ".$id."?
              </div>
              <div class='modal-footer'>
                
                    <input type = 'hidden' name = 'postid' value =' ".$id."' />
                    <button class='btn btn-danger'   type='submit' name = 'deleteYesBtn' >YES ".$id."</button>
                    
                    <button type='button' class='btn btn-primary' data-dismiss='modal'>NO</button>
               
              </div>
            </div>
          </div>
        </div>
        </form>
        
        
      </div>
    </div>";

    
    
    }
    ?>
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