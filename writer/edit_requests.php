<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
}  
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: "Arial";
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="display-4">Your Edit Requests</div>
          <?php $edit_requests = $editRequestObj->getEditRequestsFromUser($_SESSION['user_id']); ?>
          <?php foreach ($edit_requests as $request) { ?>
          <div class="card mt-4 shadow">
            <div class="card-body">
              <h5>Article ID: <?php echo $request['article_id']; ?></h5> 
              <p>Status: <?php echo $request['status']; ?></p>
              <small>Requested on: <?php echo $request['request_date']; ?> </small>
            </div>
          </div>  
          <?php } ?> 
        </div>
      </div>
    </div>
  </body>
</html>