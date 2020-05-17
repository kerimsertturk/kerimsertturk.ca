<?php


?>

<!DOCTYPE html>
<html>

	<?php include('navbar.html'); ?>
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
				border-style: solid;
				border-width:thin;
			}
			.input-field, label{
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
					margin-bottom:5%;
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
					<div class="input-field" style="margin-top:100px; padding-bottom:30px;">
						<i class="material-icons prefix">account_circle</i>
					 <input id="user_name" type="text" class="validate ">
					 <label for="user_name">username</label>
				 </div>
					<div class="input-field">
						<i class="material-icons prefix">lock</i>
						<input id="password" type="password" class="validate">
	          <label for="password">password</label>
					</div>
					<form method="post"><input class="login-btn btn z-depth-0 waves-light blue darken-2 " type="submit" name="login" value="Login"/></form>
				</div>
			</div>
		</div>
  </main>

	<?php include('footer.html'); ?>

</html>
