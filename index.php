<?php
//$_SESSION['unauthorized'] = true; // initially everywhere in the website the user is unauthorized
include('navbar.php');
require_once("pdo.php"); // pdo credentials

if(isset($_POST['login'])) {
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		unset($_SESSION['user']); // logs out previous user
		// access mysql users table to confirm username and password
		$users_stmt = $pdo->prepare("SELECT user_id,username,user_password FROM authorized_users
			WHERE username=:username AND user_password=:passwd");
		$users_stmt -> execute([
			':username' => trim($_POST['username']),
			':passwd' => trim($_POST['password']),
		]);
		$authorize_user = $users_stmt->fetch(PDO::FETCH_ASSOC);
		// if query with the entered username and password yields true then login
		if($authorize_user == true){
			$_SESSION['user'] = trim($_POST['username']); // set username to session
			$_SESSION['authorized'] = True; // set session authorization
			header('Location: index-loggedin.php'); // redirect to logged in version of home page
			return;
		}
		else{
			header('Location: index.php'); // if login incorrect redirect to home page
			return;
			}
		}
		else{
			header('Location: index.php'); // when nothing is typed but login button clicked, redirect to non-logged home page
			return;
		}
	}
	// if logged in redirect to new home page
	if(isset($_SESSION['authorized'])){
		header('Location: index-loggedin.php');
	}
?>

<html>
	<head>
		<style type="text/css">
			.welcome{
				height:500px;
				margin-top: 10%;
			}
			.welcome-msg-wrapper{
				display: inline-block;
				width:40%;
				margin-left: 20px;
				position: relative;
				top: 50%;
				transform: translateY(-50%);
			}
			.welcome-msg-text{
				margin-bottom: 8%;
			}
			.login-wrapper{
				width: 520px;
				height: 420px;
				margin-top: 60px;
				display: inline-block;
				float: right;
				position: relative;
				/*
				border-style: solid;
				border-width:thin;
				*/
			}
			.incorrect-login{
				text-align: center;
				color: red;
				padding-top: 20px;
			}
			.input-field, .login-form, label{
				padding-left: 40px;
				padding-right: 40px;
			}
			.input-field .prefix.active {
	     color: #1976d2 !important;
	   }
			.input-field input:focus + label {
     	color: #1976d2 !important;
			}
			.input-field input:focus {
	     border-bottom: 1px solid #1976d2 !important;
			 box-shadow: 0 1px 0 0 #1976d2 !important;
	   	}
			.login-btn{
				width: 20% !important;
				height: 50px !important;
				margin-top: 20px;
				margin-left: 40%;
				margin-right: 40%;
			}
			@media (max-width: 1350px){
				.welcome-msg-wrapper{
					width:80%;
					top:15%;
					margin-left: 10%;
					margin-bottom:0;
					display: inline-block;
					float:none;
				}
				.welcome-msg-text{
					margin-bottom: 3%;
				}
				.login-wrapper{
					left:50%;
					margin-left: -260px;
					margin-top: 0;
					float:none;
				}
				.input-field{
					margin-top:20px !important;
				}
		}
		</style>
	</head>

  <main>
		<div class="container">
			<div class="welcome">
				<div class="welcome-msg-wrapper">
					<div class="welcome-msg-text blue-text text-darken-4">
							<h4>Welcome to my portfolio</h4>
					</div>
						<p style="line-height:1.8; font-size:15px;">
							Some functionalities are reserved for demos, which require users to have admin rights.
							Login credentials are provided in job application packages.</p>
							<p>If you don't have the login information, please contact me explaining
							the reason for the access request.</p>
				</div>
					<div class="login-wrapper">
					<form method="post">
							<div class="input-field" style="margin-top:100px; padding-bottom:30px;">
								<i class="material-icons prefix">account_circle</i>
								<input id="user_name" type="text" name="username">
							 <label for="user_name">username</label>
						 </div>
							<div class="input-field">
								<i class="material-icons prefix">lock</i>
									<input id="password" type="password" name="password">
								<label for="password">password</label>
							</div>
							<input class="login-btn btn z-depth-0 waves-light blue darken-2 " type="submit" name="login" value="Login"/>
						</form>
						<?php
							if(isset($_SESSION["unauthorized"])){
								echo '<p class="incorrect-login">Login credentials are incorrect. Please try again</p>';
								unset($_SESSION["unauthorized"]);
							}
						?>
					</div>
			</div>
		</div>
  </main>

	<?php include('footer.html'); ?>

</html>
