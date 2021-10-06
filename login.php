<?php 
    ob_start();
    session_start();
    $pageTitle = 'Login';
    if(isset($_SESSION['user'])){
        header('Location: indexu.php');        
    }

    include 'init.php';

    //check if User coming from HTTP Post Request

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if (isset($_POST['login'])){

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);

            //Check If the User Exist In DataBase
                /*statement->$stmt */       
            $stmt = $con->prepare("SELECT 
                                        UserID, Username, Password 
                                    FROM 
                                        users 
                                    WHERE 
                                        Username = ? 
                                    AND 
                                        Password = ?");

            $stmt->execute(array($user, $hashedPass));

            $get = $stmt->fetch();

            $count = $stmt->rowCount();

            // if Count > 0 this Mean The Database Contain record about this Username

            if ($count > 0){

                $_SESSION['user'] = $user;// Register Session Name

                $_SESSION['uid'] =$get['UserID']; // Register User ID in Session

                header('Location: indexu.php');//Redirect To index Page

                exit();

            }
        
        } else {

            $formErrors  = array();

            $username    = $_POST['username'];
            $password    = $_POST['password'];
            $password2   = $_POST['password2'];
            $email       = $_POST['email'];
    
            if (isset($username)){
    
    
                $filterUser = filter_var($username , FILTER_SANITIZE_STRING);
    
                if (strlen($filterUser) < 3) {

                    $formErrors[] = 'Username Must Be Larger than 3 Characters';

                }
            }

            if (isset($password) && isset($password2)){

                if (empty($password)){
                    $formErrors[] = 'Sorry Password Can\'t Be Empty';
                }
            
                if (sha1($password) !== sha1($password2)){

                    $formErrors[] = 'Sorry Password Is Not Match';
                
                }
            
            }

            if (isset($email)){
    
    
                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    
                if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {

                    $formErrors[] = 'This Email Is Not Valid';

                }
            }

            // Check If There's No Error Proceed The User Add

            if(empty($formErrors)){

                // Check If User Exist in Database

                $check = checkItem("Username","users",$username);

                if($check == 1){

                    $formErrors[] = 'Sorry This User Is Exists';

                } else {
                    
                    // Insert userinfo In Database

                    $stmt = $con->prepare("INSERT INTO
                                        users(Username, Password, Email, RegStatus, Date)
                                        VALUES(:zuser, :zpass, :zmail, 0, now()) ");

                    $stmt->execute(array(

                        'zuser' => $username,
                        'zpass' => sha1($password),
                        'zmail' => $email,

                    ));                    

                    //Echo Success Message

                    $successMsg = 'Congrats You Are Now Registered';

                }

            }

        }

    } 


?>

<div class="container login-page">
    <h1 class="loginheader text-center">
        <span class="selected" data-class="login">Login</span> | 
        <span data-class="signup">Signup</span>
    </h1>
        <!-- Start Login Form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <label>User Name:</label>
        <div class="input-container">
        <input 
        class="form-control" 
        type="text" 
        name="username" 
        autocomplete="off"
        placeholder=" Type your Username"
        required 
        />
        </div>
       
        <label>Password:</label>
        <div class="input-container">
        <input 
        class="form-control" 
        type="password" 
        name="password" 
        autocomplete="new-password"
        placeholder="Type your Password" 
        required
        />
        </div>
        <input class="btn btn-primary btn-block" name="login" type="submit" value="Login" style="margin-top:30px"/>
    </form>
        <!-- Start Login Form -->
        
        <!-- Start Signup Form -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <label>User Name:</label>
        <div class="input-container">
        <input
        pattern=".{3,}"
        title="Name Must Be Larger than 3" 
        class="form-control" 
        type="text" 
        name="username" 
        autocomplete="off"
        placeholder="User Name"
        required/>
        </div>
        
        <label>Password:</label>
        <div class="input-container">
        <input
        minlength="10" 
        class="form-control" 
        type="password" 
        name="password" 
        autocomplete="new-password" 
        placeholder="type your Password"
        required/>
        </div>

        <label>Re-Password:</label>
        <div class="input-container">
        <input 
        class="form-control" 
        type="password" 
        name="password2" 
        autocomplete="new-password" 
        placeholder="retype your Password"
        required/>
        </div>

        <label>Email:</label>
        <div class="input-container">
        <input 
        class="form-control" 
        type="email" 
        name="email" 
        placeholder="Type a Valid Email"
        required/>
        </div>
        <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" style="margin-bottom:10px"/>
    </form>
        <!-- End Signup Form -->
        <div class="the-errors" > 
                                            
            <?php 
                if (!empty($formErrors)) {

                    foreach ($formErrors as $error) {

                        echo $error . '<br>';
                    }
                }

                if (isset($successMsg)) {

                    echo '<div class="msg success">' . $successMsg . '</div>';
                }

            ?>
        </div>
</div>


<?php
    include $tpl . 'footer.php';
    ob_end_flush();
?>

<!--the-errors style="  font-size: 18px;
                        margin-top: 0px;
                        margin-bottom: 10px;
                        font-weight: bold;
                        text-align: center;
                        color: #ff0000d9;
                        max-width: 450px;
                        margin: auto;" 
-->