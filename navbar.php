<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>kerimsertturk</title>

    <style type="text/css">
      .brand-logo{
        font-size: 20px !important;
      }
    </style>
  </head>
  <body>
    <nav class="nav-wrapper light-blue darken-4">
      <div class="container">
        <a href="index.php" class="brand-logo">home</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down" style="margin-right:-45px;">
            <?php if(isset($_SESSION['authorized'])) {
            echo '<li style="margin-right:20px;">logged in as '.$_SESSION["user"].'</li>';
            echo '<li><a class="btn blue-grey z-depth-2 waves-effect waves-light"href="logout.php">LOGOUT</a></li>';
            }
            ?>
            <li><a href="https://kerimsertturk.github.io">Blog</a></li>
            <li><a href="about.php">About</a></li>
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Projects<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="dropdown1" class="dropdown-content">
              <li><a class="blue-grey-text waves-effect waves-light text-darken-4" href="arxiv.php">Arxiv Papers DB</a></li>
              <!--
              <li><a class="blue-grey-text text-darken-4" href="#">French Vocabulary</a></li>
              <li><a class="blue-grey-text text-darken-4" href="#">Coursera Classes</a></li>
            -->
            </ul>
        </ul>
      </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
      <li><a href="index.php">Home</a></li>
      <li><a href="https://kerimsertturk.github.io">Blog</a></li>
      <li><a href="about.php">About</a></li>
      <?php if(isset($_SESSION['authorized'])) {
      echo '<li><a href="logout.php">Logout</a></li>';
      }
      ?>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Projects<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="arxiv.php">Arxiv Papers DB</a></li>
                <!--
                <li><a href="#!">French Vocabulary</a></li>
                <li><a href="#!">Coursera Classes</a></li>
                -->
              </ul>
            </div>
          </li>
        </ul>
      </li>
    </ul>

    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
      $(document).ready(function(){
      $('.sidenav').sidenav();
      });
    </script>
    <script>
      $(".dropdown-trigger").dropdown({
      'closeOnClick': false,
      'hover': false,
      'coverTrigger': false,
      'inDuration': 220
      });
    </script>

    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function () {
      var elems = document.querySelector('.collapsible');
      var instances = M.Collapsible.init(elems);
      instances.open();
      });
    </script>
  </body>
</html>
