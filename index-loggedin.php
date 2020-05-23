<html>
<?php
include('navbar.php');
?>
  <head>
    <style type="text/css">
      .welcome{
        height:500px;
        margin-top: 10%;
      }
      .welcome-msg-wrapper{
        display: inline-block;
        /*background-color: yellow;*/
        width:60%;
        margin-left: 20px;
        position: relative;
        top: 40%;
        transform: translateY(-60%);
      }
      .welcome-msg-text{
        margin-bottom: 4%;
      }
      .login-wrapper{
        width: 240px;
        height: 240px;
        margin-top: 60px;
        display: inline-block;
        float: right;
        position: relative;
        /*
        border-style: solid;
        border-width:thin;
        */
      }

      .logout-btn{
				width: 100px !important;
				height: 40px !important;
				margin-top: 45%;
				margin-left: 60px;

			}

      @media (max-width: 993px){
				.welcome-msg-wrapper{
					width:80%;
					top:25%;
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
					margin-left: -120px;
					margin-top: 2%;
					float:none;
				}
        .logout-btn{
          margin-top: 0;
        }
      }
    </style>
  </head>

  <main>

    <div class="container">
      <div class="welcome">
        <div class="welcome-msg-wrapper">
          <div class="welcome-msg-text blue-text text-darken-4">
              <h4>Logged in successfuly!</h4>
          </div>
            <p style="line-height:1.6; font-size:16px;">
              You are now granted full access. You can view all projects and perform a set of actions that aim to demonstrate various features of the projects.</p>
              <p style="line-height:1.6; font-size:16px;">Please note that a record will be kept of any changes you make to the projects or databases.</p>
        </div>
          <div class="login-wrapper">
            <?php
              if(isset($_SESSION['authorized'])) {
                echo '<a class="logout-btn btn z-depth-0 waves-light red darken-2" href="logout.php">Logout</a>';
              }
            ?>

          </div>
      </div>
    </div>

  </main>

<?php include('footer.html'); ?>
</html>
