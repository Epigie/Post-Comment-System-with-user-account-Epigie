<?php 
    session_start();
    if (!$_SESSION['andy_id']){
        ?>
            <script type="text/javascript">
                window.location = 'login.php';
            </script>
        <?php
    }
    if(isset($_GET["postId"]) && !empty(trim($_GET["postId"]))){
        require_once "config.php";
        // Prepare a select statement
        $sql = "SELECT * FROM posts WHERE postId = ?";
        $postId = trim($_GET["postId"]);
        $query = mysqli_query($Conn," 
            SELECT *,UNIX_TIMESTAMP() - postDate 
            AS TimeSpent 
            from posts  
            LEFT JOIN accounts 
            on accounts.accountId = posts.postAuthorId WHERE postId = ".$postId."
            ORDER by postId DESC
            ")or die(mysqli_error($Conn));
        if (mysqli_num_rows($query) == 1) {
            while($postRow=mysqli_fetch_array($query)){
                $postAuthor = $postRow['username'];
                $postTitle = $postRow['postTitle'];
                $postContent = $postRow['postContent'];   
                $postDate = $postRow['postDate'];
                $postUpdate= $postRow['postUpdate']; 
                $postAuthorId =  $postRow['postAuthorId'];
                $postAuthorEmail =  $postRow['email'];
                ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AndyPost | View</title>
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
                        <h2>View Post</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 feedback">
                        <div class="postCard">
                            <div class="form-group cardHead">
                                <h3><?php echo $postTitle; ?></h3>
                            </div>
                            <div class="form-group cardContent">
                                <p><b><?php echo $postContent; ?></b></p>
                            </div>
                            <div class="form-group cardFoot">
                                <p>
                                    <i>By: </i><b><?php echo $postAuthor; ?></b>
                                    <br> 
                                    <a href='emailto:<?php echo $postAuthorEmail;?>'>
                                        <?php echo $postAuthorEmail;?>
                                    </a>
                                </p>
                                <?php
                                    if ($postAuthorId == $_SESSION['andy_id']) {
                                ?>
                                <center>
                                    <div>
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
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>
                <?php
            }
            mysqli_free_result($query); 
        }else{
            ?>
                <script type="text/javascript">
                    window.location = 'error.php';
                </script>
            <?php
            exit();
        }
    }mysqli_close($Conn);
?>

