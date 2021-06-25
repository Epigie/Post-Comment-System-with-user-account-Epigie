<?php
    session_start();
    if (!$_SESSION['andy_id']){
        ?>
            <script type="text/javascript">
                window.location = 'login.php';
            </script>
        <?php
    }
    require_once "config.php";
    $postTitle = $postContent = "";
    $postTitle_err = $postContent_err = "";
    if(isset($_POST["postId"]) && !empty($_POST["postId"])){
        $postId = $_POST["postId"];
        //title
        $inputTitle = trim($_POST["postTitle"]);
        if(empty($inputTitle)){
            $postTitle_err = "Please enter a Post Title.";
        } elseif(!filter_var($inputTitle, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $postTitle_err = "Please enter a valid Post Title.";
        } else{
            $postTitle = $inputTitle;
        }
        //content
        $inputContent = trim($_POST["postContent"]);
        if(empty($inputContent)){
            $postContent_err = "Post Content can not be empty.";     
        } else{
            $postContent = $inputContent;
        }
        // Check input errors before inserting in database
        if(empty($postTitle_err) && empty($postContent_err)){
            $sql = "UPDATE posts SET postTitle=?, postContent=?, postUpdate=CURRENT_TIMESTAMP WHERE postId=?";
             
            if($stmt = mysqli_prepare($Conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssi", $param_postTitle, $postContent, $param_postId);
                
                // Set parameters
                $param_postTitle = $postTitle;
                $param_postContent = $postContent;
                $param_postId = $postId;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    ?>
                        <script type="text/javascript">
                            window.location = 'index.php';
                        </script>
                    <?php
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($Conn);
    } else{
        // Check existence of post Id parameter before processing further
        if(isset($_GET["postId"]) && !empty(trim($_GET["postId"]))){
            $postId =  trim($_GET["postId"]);
            
            // Prepare a select statement
            $sql = "SELECT * FROM posts WHERE postId = ?";
            if($stmt = mysqli_prepare($Conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_postId);
                $param_postId = $postId;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result) == 1){
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        $postTitle = $row["postTitle"];
                        $postContent = $row["postContent"];
                    } else{
                        // URL doesn't contain valid postId. Redirect to error page
                        ?>
                            <script type="text/javascript">
                                window.location = 'error.php';
                            </script>
                        <?php
                        exit();
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($Conn);
        }  else{
            // URL doesn't contain postId parameter. Redirect to error page
            ?>
                <script type="text/javascript">
                    window.location = 'error.php';
                </script>
            <?php
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AndyPost | Edit</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/forall.css">
        <script type="" src="js/jquery-3.6.0.min.js"></script>
        <script type="" src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row" align="center">
                    <div class="header">
                        <h2>Edit Post</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 main">
                        <div class="row">
                            <p>
                                Welcome <b><?php echo $_SESSION['andy_name'];?></b> 
                                <a href="index.php" class="btn btn-success" style="float: right;">
                                    Home
                                </a>
                            </p>
                        </div>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group">
                                <label>Post Title</label>
                                <input type="text" name="postTitle" class="form-control <?php echo (!empty($postTitle_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postTitle; ?>">
                                <span class="invalid-feedback"><?php echo $postTitle_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Post Content</label>
                                <textarea name="postContent" rows="5" cols="5" style="resize: none;" class="form-control <?php echo (!empty($postContent_err)) ? 'is-invalid' : ''; ?>"><?php echo $postContent; ?></textarea>
                                <span class="invalid-feedback"><?php echo $postContent_err;?></span>
                            </div>
                            <input type="hidden" name="postId" value="<?php echo $postId; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>