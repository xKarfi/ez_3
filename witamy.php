
<?php

	session_start();
	
//	if (!isset($_SESSION['udanarejestracja']))
//	{
//		header('Location: index.php');
//		exit();
//	}
//	else
//	{
//		unset($_SESSION['udanarejestracja']);
//	}
	
	
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);

	
	
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	
	
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
            <div id="border-register">
                <h2>You registered succesfully!</h2>
				<a href=login.php><h3>Click here to sign in!</h3></a>
				
                
        </div>
    </div>
        
        
    </body>
</html>