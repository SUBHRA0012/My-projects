<?php include 'partials/_dbconnect.php';
session_start();
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $qry = mysqli_query($conn, "SELECT status FROM userbase WHERE user_id = '$user_id'");
  $row_status = mysqli_fetch_assoc($qry);
  if ($row_status && $row_status['status'] == 'blocked') {
    unset($_SESSION['loggedin']);
    unset($_SESSION['user_id']);
    header('location: index.php?ban=true');
    exit;
  }
}

$count = 0;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['user_id'])) {
  $uid = $_SESSION['user_id'];
  $countSql = "SELECT COUNT(*) as total FROM `carts` WHERE `user_id` = '$uid'";
  $countRes = mysqli_query($conn, $countSql);

  if ($countRes) {
    $row = mysqli_fetch_assoc($countRes);
    $count = $row['total'];
  }
} else {
  $count = 0;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PureGrocery</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="assets/footer.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drift-zoom/dist/drift-basic.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg py-3" style="background: rgb(1, 49, 1);" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand text-white fw-bold ms-0 ms-md-5 ps-md-4" style="font-size: 1.4rem;" href="index.php">
        <i class="bi bi-cart4"></i> PureGrocery
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse ms-0 ms-lg-n5" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="about.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="contUs.php">Contact Us</a>
          </li>
        </ul>

        <ul class="navbar-nav text-center pe-md-5 me-md-4">
          <li class="nav-item">
            <a class="nav-link text-white position-relative d-inline-block d-lg-block" href="cart.php">
              <i class="bi bi-cart4"></i> Cart
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                <?php echo $count ?>
              </span>
            </a>
          </li>

          <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                <?php echo $_SESSION['username'] ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="my_orders.php"><i class="fa-solid fa-box me-2"></i> My orders</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="partials/_logout.php"><i class="fa-solid fa-power-off me-2"></i> Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <button class="nav-link text-white bg-transparent border-0 w-100" onclick="openPopup('loginOverlay')">Login</button>
            </li>
            <li class="nav-item">
              <button class="nav-link text-white bg-transparent border-0 w-100" onclick="openPopup('signinOverlay')">Register</button>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div id="custom-alert"
    class="d-none position-fixed top-0 start-50 translate-middle-x mt-5 
            bg-danger text-white text-center p-4 rounded shadow"
    style="z-index: 9999; min-width: 350px; font-weight: bold; font-size: 1.3rem;">
  </div>

  <?php include '_login.php';
  include '_signin.php';
  ?>

  <script>
    const isLoggedIn = "<?php echo isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) == true ? 'true' : 'false' ?>"
  </script>