<?php session_start();
$lg = false;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum/">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <?php
              $sql = "SELECT catagory_title, catagory_id FROM `catagory`;";
              $result = mysqli_query($conn,$sql);
              while ($row = mysqli_fetch_array($result)) {
                echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row["catagory_id"].'">'.substr($row["catagory_title"], 0, 22).'</a></li>';
              }
            ?>
           
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cont.php">Contact</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="search.php">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-success me-2" type="submit">Search</button>
        <?php
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
            $lg = true;
            echo '
              <p class="text-light my-2 me-2">'.$_SESSION["user"].'</P>
              <a type="button" href="/forum/partials/_logout.php" class="btn btn-outline-success me-2">Logout</a>
            ';
          }
          else{
            $lg = 'false';
            echo '
              <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
            
            ';
            
          }
        
        ?>
        <!-- <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button> -->
      </form>
    </div>
  </div>
</nav>

<?php include "partials/_login.php";
include "partials/_signup.php";
?>

<?php

if(isset($_GET["sign"]) && $_GET["sign"] == "true"){
  echo '
      <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>Success!</strong>Your account hasbeen created, now you can login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  
  ';
}
if(isset($_GET["log"]) && $_GET["log"] == "true"){
  echo '
      <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>Loggedin!</strong>Welcome
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  
  ';
}elseif(isset($_GET["log"]) && $lg == 'false'){
  echo '
      <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
        <strong>Login Denied!</strong>Wrong Username or password
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
}
if(isset($_GET['out']) && $_GET['out'] == 'true'){
  echo '
      <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>Logged out!</strong>You loggedout.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  
}

?>


<script>
  if (window.history.replaceState) {
    const url = new URL(window.location);
    url.searchParams.delete('sign');
    url.searchParams.delete('log');
    url.searchParams.delete('out');
   // window.history.replaceState({}, document.title, url.pathname);
    window.history.replaceState({}, document.title, url.pathname + '?' + url.searchParams.toString());
  }
</script>
