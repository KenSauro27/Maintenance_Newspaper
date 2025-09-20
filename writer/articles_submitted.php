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
    <title>My Articles</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4 text-center my-5">My Submitted Articles</h1>
                <p class="text-center text-muted">Double-click on an article to edit it.</p>
                <?php $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']); ?>
                <?php foreach ($articles as $article) { ?>
                <div class="card shadow mb-4 articleCard">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $article['title']; ?></h3>
                        <p class="text-muted">Published on <?php echo date("F j, Y", strtotime($article['created_at'])); ?></p>
                        <?php if ($article['is_active'] == 0) { ?>
                            <p class="text-warning">Status: Pending Review</p>
                        <?php } else { ?>
                            <p class="text-success">Status: Published</p>
                        <?php } ?>
                        <p><?php echo $article['content']; ?> </p>
                        <div class="d-flex justify-content-between">
                            <form class="deleteArticleForm">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                                <input type="submit" class="btn btn-danger deleteArticleBtn" value="Delete">
                            </form>
                            <form class="requestEditForm">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                                <input type="submit" class="btn btn-info requestEditBtn" value="Request Edit">
                            </form>
                        </div>
                        <div class="updateArticleForm d-none mt-4">
                            <h4>Edit Article</h4>
                            <form action="core/handleForms.php" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                                </div>
                                <div class="form-group">
                                    <textarea name="description" class="form-control" rows="5"><?php echo $article['content']; ?></textarea>
                                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                    <input type="submit" class="btn btn-primary mt-3" name="editArticleBtn" value="Save Changes">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
                <?php } ?> 
            </div>
        </div>
    </div>
    <script>
      $('.articleCard').on('dblclick', function (event) {
        var updateArticleForm = $(this).find('.updateArticleForm');
        updateArticleForm.toggleClass('d-none');
      });

      $('.deleteArticleForm').on('submit', function (event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).find('.article_id').val(),
          deleteArticleBtn: 1
        }
        if (confirm("Are you sure you want to delete this article?")) {
          $.ajax({
            type:"POST",
            url: "core/handleForms.php",
            data:formData,
            success: function (data) {
              if (data) {
                location.reload();
              } else {
                alert("Deletion failed");
              }
            }
          })
        }
      })

      $('.requestEditForm').on('submit', function (event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).find('.article_id').val(),
          requestEditBtn: 1
        }
        if (confirm("Are you sure you want to request an edit for this article?")) {
          $.ajax({
            type:"POST",
            url: "core/handleForms.php",
            data:formData,
            success: function (data) {
              if (data) {
                alert("Edit request sent!");
              } else {
                alert("Edit request failed");
              }
            }
          })
        }
      })
    </script>
  </body>
</html>