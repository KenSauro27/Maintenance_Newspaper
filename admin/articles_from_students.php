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
    <title>Pending Articles</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4 text-center my-5">Pending Student Articles</h1>
                <?php $articles = $articleObj->getPendingArticles(); ?>
                <?php foreach ($articles as $article) { ?>
                <div class="card shadow mb-4 articleCard">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $article['title']; ?></h3>
                        <p class="text-muted">by <?php echo $article['username']; ?> on <?php echo date("F j, Y", strtotime($article['created_at'])); ?></p>
                        <?php if($article['image_path']) {?>
                            <img src="<?php echo (strpos($article['image_path'], 'uploads/') === false) ? '../uploads/' . $article['image_path'] : '../' . $article['image_path']; ?>" class="img-fluid rounded mb-3">
                        <?php } ?>
                        <p><?php echo $article['content']; ?> </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <form class="updateArticleStatus">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                                <select name="is_active" class="form-control is_active_select" article_id=<?php echo $article['article_id']; ?>>
                                    <option value="">Set Status</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Active</option>
                                </select>
                            </form>
                            <form class="deleteArticleForm">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                                <input type="submit" class="btn btn-danger deleteArticleBtn" value="Delete">
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

      $('.is_active_select').on('change', function (event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).attr('article_id'),
          status: $(this).val(),
          updateArticleVisibility:1
        }

        if (formData.article_id != "" && formData.status != "") {
          $.ajax({
            type:"POST",
            url: "core/handleForms.php",
            data:formData,
            success: function (data) {
              if (data) {
                location.reload();
              } else {
                alert("Visibility update failed");
              }
            }
          })
        }
      })
    </script>
  </body>
</html>