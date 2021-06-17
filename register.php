<?php

	session_start();
	
	if (isset($_POST['email']))
	{
	
		$wszystko_OK=true;
		
		
		$nick = $_POST['nick'];
		
	
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Login must be 3 to 20 characters long! ";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Login can only consist of letters and numbers ";
		}
		
	
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Please enter a valid e-mail address! ";
		}
		
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="The password must be 8 to 20 characters long! ";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Passwords are different!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		
		
		require_once "conn.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				
				$rezultat = $polaczenie->query("SELECT user_id FROM users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="There is already an account assigned to this e-mail address! ";
				}		

				
				$rezultat = $polaczenie->query("SELECT user_id FROM users WHERE username='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="There is already a person with this username! Choose another. ";
				}
				
				if ($wszystko_OK==true)
				{
					
					
					if ($polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
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
            <div id="border-register">
                <h1>Sign up</h1>
                <form method="POST">
                    <input type="text" id="e-mail" name="email" placeholder="E-mail" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>">
        <?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?><br />

                   <input type="text" class="login" name="nick" placeholder="Login" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>">
        <?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?><br />
		



                   <input type="password" class="password" name="haslo1" placeholder="Password" value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>">
        <?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?><br />

                  <input type="password" id="cpassword" name="haslo2" placeholder="Confirm password" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>">
                    <button type="submit" id="button-register" name="button-register">Sign up </button>
                </form>
                
            </div>
        </div>
    </div>
        
        
    </body>
</html>