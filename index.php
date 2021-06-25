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
    $postTitle = $postContent = $postAuthorId = "";
    $postTitle_err = $postContent_err = $postAuthorId_err = "";
     
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate post title
        $inputTitle = trim($_POST["postTitle"]);
        if(empty($inputTitle)){
            $postTitle_err = "Please enter a post title.";
        } elseif(!filter_var($inputTitle, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $postTitle_err = "Please enter a valid post title.";
        } else{
            $postTitle = $inputTitle;
        }

        $inputContent = trim($_POST["postContent"]);
        if(empty($inputContent)){
            $postContent_err = "Post Content can not be empty.";     
        } else{
            $postContent = $inputContent;
        }

        $postAuthorId = $_SESSION['andy_id'];
        
        if(empty($postTitle_err) && empty($postContent_err) && empty($postAuthorId_err)){
            $query = "
                INSERT INTO posts (postAuthorId, postTitle, postContent, postDate) 
                VALUES ('$postAuthorId', '$postTitle', '$postContent', CURRENT_TIMESTAMP)";
            $result = mysqli_query($Conn, $query);
            if ($result) {
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
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AndyPost | Home</title>
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
                        <h2>Home Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 main">
                        <div class="row">
                            <p>
                                Welcome <b><?php echo $_SESSION['andy_name'];?></b> 
                                <a href="logout.php" class="btn btn-danger" style="float: right;">
                                    Logout
                                </a>
                            </p>
                        </div>
                        <h2 align="center" class="mt-3">Create Post</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <input type="text" name="postTitle"placeholder="Post Title" class="form-control <?php echo (!empty($postTitle_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postTitle; ?>">
                                <span class="invalid-feedback"><?php echo $postTitle_err;?></span>
                            </div>
                            <div class="form-group">
                                <textarea name="postContent" rows="5" cols="5" class="form-control <?php echo (!empty($postContent_err)) ? 'is-invalid' : ''; ?>" placeholder="Post Content" style="resize: none;"><?php echo $postContent; ?></textarea>
                                <span class="invalid-feedback"><?php echo $postContent_err;?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 feedback">
                        <?php
                            require_once "config.php";
                            $query = mysqli_query($Conn,"
                                SELECT *,UNIX_TIMESTAMP() - postDate 
                                AS TimeSpent 
                                from posts 
                                LEFT JOIN accounts 
                                on accounts.accountId = posts.postAuthorId 
                                order by postId 
                                DESC")or die(mysqli_error());
                            if (mysqli_num_rows($query) > 0) {
                                while($postRow=mysqli_fetch_array($query)){
                                    $postId = $postRow['postId'];    
                                    $postAuthor = $postRow['username'];
                                    $postTitle = $postRow['postTitle'];
                                    $postContent = $postRow['postContent'];   
                                    $postDate = $postRow['postDate'];
                                    $postUpdate= $postRow['postUpdate']; 
                                    $postAuthorId =  $postRow['postAuthorId'];
                                    $postAuthorEmail =  $postRow['email'];
                                    ?>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <div class="postCard">
                                                <div class="form-group cardHead">
                                                    <h3><?php echo $postTitle; ?></h3>
                                                </div>
                                                <div class="form-group cardContent">
                                                    <p><b><?php echo $postContent; ?></b></p>
                                                </div>
                                                <div class="form-group cardFoot">
                                                    <p>
                                                        <i>By: </i>
                                                        <b><?php echo $postAuthor; ?> </b>
                                                        <small style="float: right;">
                                                            <?php
                                                                echo $postDate;
                                                            ?>
                                                        </small>
                                                        <br> 
                                                        <a href='emailto:<?php echo $postAuthorEmail;?>'>
                                                            <?php echo $postAuthorEmail;?>
                                                        </a>
                                                    </p>
                                                    <center>
                                                        <div>
                                                            <a href="view.php?postId=<?php echo$postId;?>" class="btn btn-success" title="View Record">
                                                                View
                                                            </a>
                                                            <?php
                                                                if ($postAuthorId == $_SESSION['andy_id']) {
                                                            ?>
                                                            <a href="update.php?postId=<?php echo $postId;?>" class="btn btn-primary" title="Update Record">
                                                                Edit
                                                            </a>
                                                            <a href="delete.php?postId=<?php echo $postId;?>" class="btn btn-danger" title="Delete Record">
                                                                Delete
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                mysqli_free_result($query);
                            } else{
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }
                            mysqli_close($Conn);
                        ?>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>