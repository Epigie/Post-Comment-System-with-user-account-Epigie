<?php
    session_start();
    if (isset($_SESSION['andy_id'])){
        ?>
            <script type="text/javascript">
                window.location = 'index.php';
            </script>
        <?php
    }
    include 'server.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AndyPost | Home</title>
        <link rel="stylesheet" href="css/forall.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row" align="center">
                    <div class="header">
                        <h2>Login Page</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 main">
                        <form method="post" action="login.php">
                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" name="email" >
                            </div>
                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" name="password">
                            </div>
                            <div class="input-group">
                                <button type="submit" style="padding: 10px;font-size: 15px;color: white;background: #5480ff;border: none;border-radius: 5px;" name="loginBtn">
                                    Login
                                </button>
                            </div>
                            <p>
                                Not yet a member? 
                                <a href="signup.php">
                                    Sign up
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>