<?php  
require_once '../classloader.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = htmlspecialchars(trim($_POST['username']));
	$email = htmlspecialchars(trim($_POST['email']));
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (!$userObj->usernameExists($username)) {

				if ($userObj->registerUser($username, $email, $password)) {
					header("Location: ../login.php");
				}

				else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			}

			else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	}
	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
			header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		if ($userObj->loginUser($email, $password)) {
			header("Location: ../index.php");
		}
		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}

}

if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}

if (isset($_POST['insertAdminArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author_id = $_SESSION['user_id'];
	$image_path = null;

    if (isset($_FILES['articleImage']) && $_FILES['articleImage']['error'] == 0) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["articleImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["articleImage"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["articleImage"]["tmp_name"], $target_file)) {
                $image_path = basename($_FILES["articleImage"]["name"]);
            }
        }
    }

	if ($articleObj->createArticle($title, $description, $author_id, $image_path)) {
		header("Location: ../index.php");
	}

}

if (isset($_POST['editArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$article_id = $_POST['article_id'];
	if ($articleObj->updateArticle($article_id, $title, $description)) {
		header("Location: ../articles_submitted.php");
	}
}

if (isset($_POST['deleteArticleBtn'])) {
	$article_id = $_POST['article_id'];
    $notify = isset($_POST['notify']) ? true : false;
	echo $articleObj->deleteArticle($article_id, $notify);
}

if (isset($_POST['updateArticleVisibility'])) {
	$article_id = $_POST['article_id'];
	$status = $_POST['status'];
	echo $articleObj->updateArticleVisibility($article_id,$status);
}

if (isset($_POST['updateEditRequestBtn'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    echo $editRequestObj->updateEditRequestStatus($request_id, $status);
}

if (isset($_POST['approveEditRequestBtn'])) {
    $request_id = $_POST['request_id'];
    if ($editRequestObj->updateEditRequestStatus($request_id, 'approved')) {
        header("Location: ../incoming_edit_requests.php");
    }
}

if (isset($_POST['rejectEditRequestBtn'])) {
    $request_id = $_POST['request_id'];
    if ($editRequestObj->updateEditRequestStatus($request_id, 'rejected')) {
        header("Location: ../incoming_edit_requests.php");
    }
}