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
    <title>Writer Dashboard</title>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow my-5">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Submit a New Article</h2>
                        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter a catchy title">
                            </div>
                            <div class="form-group">
                                <label for="description">Content</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Write your article content here"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="articleImage">Featured Image</label>
                                <input type="file" class="form-control-file" name="articleImage">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4" name="insertArticleBtn">Submit for Review</button>
                        </form>
                    </div>
                </div>

                <hr class="my-5">

                <h2 class="text-center display-4 mb-5">Published Articles</h2>

                <?php $articles = $articleObj->getActiveArticles(); ?>
                <?php foreach ($articles as $article) { ?>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $article['title']; ?></h3>
                        <p class="text-muted">by <?php echo $article['username']; ?> on <?php echo date("F j, Y", strtotime($article['created_at'])); ?></p>
                        <?php if($article['image_path']) {?>
                            <img src="<?php echo (strpos($article['image_path'], 'uploads/') === false) ? '../uploads/' . $article['image_path'] : '../' . $article['image_path']; ?>" class="img-fluid rounded mb-3">
                        <?php } ?>
                        <p><?php echo substr($article['content'], 0, 200); ?>...</p>
                        <?php if ($article['author_id'] != $_SESSION['user_id']) { ?>
                            <form class="requestEditForm d-inline-block">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                                <input type="submit" class="btn btn-info requestEditBtn" value="Request Edit">
                            </form>
                        <?php } ?>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
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