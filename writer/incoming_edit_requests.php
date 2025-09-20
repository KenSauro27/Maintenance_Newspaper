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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <title>Incoming Edit Requests</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4 text-center my-5">Incoming Edit Requests</h1>
                <?php $edit_requests = $editRequestObj->getIncomingEditRequests($_SESSION['user_id']); ?>
                <?php foreach ($edit_requests as $request) { ?>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Request from: <?php echo $request['username']; ?></h5>
                        <p>Article ID: <?php echo $request['article_id']; ?></p>
                        <p>Status: <span class="font-weight-bold"><?php echo ucfirst($request['status']); ?></span></p>
                        <small class="text-muted">Requested on: <?php echo date("F j, Y", strtotime($request['request_date'])); ?></small>
                        <?php if ($request['status'] == 'pending') { ?>
                            <div class="mt-3">
                                <form class="d-inline-block" action="core/handleForms.php" method="POST">
                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                    <input type="submit" name="approveEditRequestBtn" class="btn btn-success" value="Approve">
                                </form>
                                <form class="d-inline-block" action="core/handleForms.php" method="POST">
                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                    <input type="submit" name="rejectEditRequestBtn" class="btn btn-danger" value="Reject">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>  
                <?php } ?> 
            </div>
        </div>
    </div>
  </body>
</html>