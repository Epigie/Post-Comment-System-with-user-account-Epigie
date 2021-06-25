<?php
    $username = "";
    $email    = "";
    $errors = array(); 
    $Conn = mysqli_connect('localhost', 'root', '', 'andy');

    function formatData($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Registration
    if (isset($_POST['regBtn'])) {
        $username = mysqli_real_escape_string($Conn, formatData($_POST['username']));
        $email = mysqli_real_escape_string($Conn, formatData($_POST['email']));
        $passwordOne = mysqli_real_escape_string($Conn, formatData($_POST['passwordOne']));
        $passwordTwo = mysqli_real_escape_string($Conn, formatData($_POST['passwordTwo']));

        if (empty($username)) { 
            array_push($errors, "Username is required"); 
        }
        if (empty($email)) { 
            array_push($errors, "Email is required"); 
        }
        if (empty($passwordOne)) { 
            array_push($errors, "Password is required");
        }
        if ($passwordOne != $passwordTwo) {
            array_push($errors, "The Passwords do not match");
        }

        $userCheckQuery = "
            SELECT * FROM accounts 
            WHERE username='$username' 
            OR email='$email' 
            LIMIT 1";
        $result = mysqli_query($Conn, $userCheckQuery);
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }
            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }
        if (count($errors) == 0) {
            $password = md5($passwordOne);
            $query = "
                INSERT INTO accounts (username, email, password) 
                VALUES('$username', '$email', '$password')";
            mysqli_query($Conn, $query);
            //Getting Other details;
            $selectQuery = "SELECT * FROM accounts WHERE email = '$email'";
            $result = mysqli_query($Conn, $selectQuery);
            $accounRrow = mysqli_fetch_assoc($result);

            $_SESSION['andy_id'] = $accounRrow['accountId']; 
            $_SESSION['andy_name'] = $accounRrow['username']; 
            $_SESSION['andy_email'] =  $accounRrow['email'];
            $_SESSION['andy_date'] =  $accounRrow['date'];
            ?>
                <script type="text/javascript">
                    window.location = 'index.php';
                </script>
            <?php
        }
    }
    // Login
    if (isset($_POST['loginBtn'])) {
        $email = mysqli_real_escape_string($Conn, $_POST['email']);
        $password = mysqli_real_escape_string($Conn, $_POST['password']);
        if (empty($email)) {
            array_push($errors, "Email is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
        if (count($errors) == 0) {
            $password = md5($password);
            $query = "
            SELECT * FROM accounts 
            WHERE email='$email' 
            AND password='$password'";
            $results = mysqli_query($Conn, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";

                //Getting Other details;
                $selectQuery = "SELECT * FROM accounts WHERE email = '$email'";
                $result = mysqli_query($Conn, $selectQuery);
                $accounRrow = mysqli_fetch_assoc($result);

                $_SESSION['andy_id'] = $accounRrow['accountId']; 
                $_SESSION['andy_name'] = $accounRrow['username']; 
                $_SESSION['andy_email'] =  $accounRrow['email'];
                $_SESSION['andy_date'] =  $accounRrow['date'];
                ?>
                    <script type="text/javascript">
                        window.location = 'index.php';
                    </script>
                <?php

            }else {
                array_push($errors, "Wrong Email or Password combination");
            }
        }
    }
    
    if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
        <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php  endif ?>