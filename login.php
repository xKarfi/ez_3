<?php

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
require_once "config.php";
 

$username = $password = "";
$username_err = $password_err = $login_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
  
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
  
    if(empty($username_err) && empty($password_err)){
       
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
          
            $param_username = $username;
            
          
            if(mysqli_stmt_execute($stmt)){
               
                mysqli_stmt_store_result($stmt);
                
             
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                   
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                           
                            session_start();
                            
                         
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;                            
                            
                          
                            header("location: welcome.php");
                        } else{
                           
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                   
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

           
            mysqli_stmt_close($stmt);
        }
    }
  

}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ofix</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
        <link href="fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div id="container">
        <div id="header">
            <a href="index.php"><div id="logo">
                <img src="logo.png">
                <p>Ofix</p>
            </div></a>
            <div id="search-bar">
                
                <div  id="search-box">
                    <input type="text" placeholder="Search for anything...">
                    <a href="#"><i class="fas fa-search"></i></a>
                </div>
            
            
            </div>
            <div id="courses">
                <h1>My courses</h1>
            </div>
            
            <div id="wishlist">
                <a href=#wish><i class="fas fa-clipboard-list"></i></a>
            </div>
            <div id="cart">
                <a href=#cart><i class="fas fa-shopping-cart"></i></a>
            </div>
            
            <div id="sign-up">
                <a href="register.php">
                <button>Sign up</button>
                </a>
            </div>
            <div id="sign-in">
                <a href="login.php">
                <button>Sign in</button>
                </a>
            </div>
            
        </div>
       
        
        <div class="content-login">
            <div id="border-login">
                <h1>Sign in</h1>
                <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="text" name="username" placeholder="Login" class="login <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <?php echo $username_err; ?>
                    <input type="password" name="password" placeholder="Password" class="password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <?php echo $password_err; ?>
                    <button type="submit" id="button-login" name="button-login">Log in </button>
                </form>
                <h4>Don't have an account yet? <a href="register.php">Sign up now!</a></h4>
            </div>
        </div>
    </div>
        
        
    </body>
</html>