<?php
    session_start();
    if (!$_SESSION['andy_id']){
        ?>
            <script type="text/javascript">
                window.location = 'login.php';
            </script>
        <?php
    }
    if(isset($_POST["postId"]) && !empty($_POST["postId"])){
        // Include config file
        require_once "config.php";
        
        // Prepare a delete statement
        $sql = "DELETE FROM posts WHERE postId = ?";
        
        if($stmt = mysqli_prepare($Conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = trim($_POST["postId"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records deleted successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($Conn);
    } else{
        // Check existence of postId parameter
        if(empty(trim($_GET["postId"]))){
            // URL doesn't contain postId parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Post</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="postId" value="<?php echo trim($_GET["postId"]); ?>"/>
                            <p>Are you sure you want to delete this Post?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>