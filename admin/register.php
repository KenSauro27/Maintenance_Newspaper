<?php require_once 'classloader.php'; ?>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <title>Admin Registration</title>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 p-5">
        <div class="card shadow">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Admin Registration</h2>
            <?php  
              if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                if ($_SESSION['status'] == "200") {
                  echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
                } else {
                  echo "<div class='alert alert-danger'>{$_SESSION['message']}</div>"; 
                }
              }
              unset($_SESSION['message']);
              unset($_SESSION['status']);
            ?>
            <form action="core/handleForms.php" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
              </div>
              <input type="submit" class="btn btn-primary btn-block mt-4" name="insertNewUserBtn" value="Register">
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>