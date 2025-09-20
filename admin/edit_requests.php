<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
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
    <title>Edit Requests</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4 text-center my-5">Article Edit Requests</h1>
                <?php $edit_requests = $editRequestObj->getEditRequests(); ?>
                <?php foreach ($edit_requests as $request) { ?>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Request ID: <?php echo $request['request_id']; ?></h5>
                        <p>Article ID: <?php echo $request['article_id']; ?></p>
                        <p>Requester ID: <?php echo $request['requester_id']; ?></p>
                        <p>Status: <span class="font-weight-bold"><?php echo ucfirst($request['status']); ?></span></p>
                        <small class="text-muted">Requested on: <?php echo date("F j, Y", strtotime($request['request_date'])); ?></small>
                        <form class="updateEditRequestForm mt-3">
                            <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="pending" <?php if($request['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="approved" <?php if($request['status'] == 'approved') echo 'selected'; ?>>Approved</option>
                                    <option value="rejected" <?php if($request['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                                </select>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Update Status">
                        </form>
                    </div>
                </div>  
                <?php } ?> 
            </div>
        </div>
    </div>
    <script>
      $('.updateEditRequestForm').on('submit', function (event) {
        event.preventDefault();
        var formData = {
          request_id: $(this).find('input[name=request_id]').val(),
          status: $(this).find('select[name=status]').val(),
          updateEditRequestBtn: 1
        }
        $.ajax({
          type:"POST",
          url: "core/handleForms.php",
          data:formData,
          success: function (data) {
            if (data) {
              location.reload();
            } else {
              alert("Update failed");
            }
          }
        })
      })
    </script>
  </body>
</html>