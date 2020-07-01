<?php
include('navbar.php');
?>
<html>
<head>
  <style type="text/css">
    table{
      font-size: 15px;
    }
    .project-info{
      float:left;
      margin-top:10px;
    }
    .info-modal-text p{
      /* font-size: 16px; */
      line-height: 1.80em;
    }
    .log-table{
      margin-top: 10px;
      float: right;
    }
    .id-col{
      width:40px;
      text-align: left;
    }
    .title-col{
      width: 700px;
      text-align: center;
    }
    .date-col{
      width: 130px;
      text-align: left;
    }
    .abstract-col{
      width: 100px;
    }
    .read-btn{
      margin:auto;
      display: block;
    }
    .remove-btn{
      margin:auto;
      display: block;
    }
    input, .unauth-button{
      font-weight: bold;
    }
    .set-read{
      width:100px;
    }
    .remove{
      width:100px;
    }
    .pagination {
      margin-left: 45%;
      margin-right: 35%;
      width: 20%;
      display: flex;
    }
    .update{
    display: inline;
    }
  </style>
</head>

	<?php
  include('materialize.php');
  require_once("pdo.php");

  // pagination stuff
  $limitperpage = 12;
  if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
  }
  else { $page = 1; }

  $start_each_page = ($page - 1) * $limitperpage;

  $arxiv_papers = $pdo->prepare("SELECT id,title,arxivid,visit_time,abs_url,read_pdf,abstract FROM arxiv_papers ORDER BY visit_time DESC LIMIT $start_each_page, $limitperpage");
  $arxiv_papers -> execute();

  $count_rows_query = $pdo -> query("SELECT count(id) from arxiv_papers");
  $count_rows = $count_rows_query -> fetchColumn();
  $num_pagination_pages = ceil($count_rows/$limitperpage);

  // logic for pagination chevrons
  if ($page == 1){
    $prev_page = 1;
  }
  else{
    $prev_page = $page - 1;
  }
  if($page == $num_pagination_pages){
    $next_page = $page;
  }
  else{
    $next_page = $page + 1;
  }
  ?>
  <main>

    <!--
    <div class="update container col s12 l6 m4">
      <p>Last Updated on: </p>
    </div>
    -->
    <div class="container">
      <a class="project-info btn modal-trigger z-depth-0 blue-grey darken-1 waves-effect waves-light" href="#info_modal">project info</a>
      <a class="log-table btn z-depth-0 black-text lime waves-effect waves-light" href="papers_log.php">CHANGE LOG</a>
    </div>

    <div class="modal" id="info_modal">
      <div class="info-modal-text modal-content">
        <h5><b>Background Information</b></h5>
          <p>The problem that lead to this project was the difficulty of keeping track of open-access ML papers that I discover while browsing,
          and find interesting. The standard approach would be to download and save them in a folder, which takes significant space
          on the hard drive and requires a seperate tracking sheet in which records would have to be manually entered. Not only is this process tedious, but
          with too many records, one would have to open the pdfs again and refer back to the abstracts to remember the contents.
          <p>The table on this page solves the issues by keeping track of all papers visited with easy access to the abstracts and ability
          to set if they are read as well as to remove them from the database. A log table keeps track of all the changes made by any user.
          Removed records can be restored through the log table. </p>
          <p>The project is made with Python, PHP, MySQL, HTML/CSS and Materialize design framework.
            The code is available at <a href="https://github.com/kerimsertturk/kerimsertturk.ca">my github repo.</a></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close blue btn-flat white-text">Close</a>
      </div>
    </div>

    <!-- Pagination -->
    <ul class="pagination">
     <li class="waves-effect"><a href="arxiv.php?page=<?= $prev_page; ?>"><i class="material-icons">chevron_left</i></a></li>
     <?php
     for($page_index=1; $page_index <= $num_pagination_pages; $page_index++):
      if($page == $page_index) {
        $class_active = 'active blue'; }
      else {
        $class_active = '';
      } ?>
      <li class="<?= $class_active ?> waves-effect"><a href="arxiv.php?page=<?= $page_index; ?>"><?= $page_index; ?></a></li>
    <?php endfor ?>
     <li class="waves-effect"><a href="arxiv.php?page=<?= $next_page; ?>"><i class="material-icons">chevron_right</i></a></li>
   </ul>


    <div class="container">
      <table class="responsive-table striped">
        <thead>
          <tr>
            <th class='id-col'>Id</th>
            <th class='title-col'>Title</th>
            <th class='date-col'>Access Date</th>
            <th class='abstract-col'>Abstract</th>
            <th class='set-read'>Set Read on Click</th>
            <th class='remove'></th>
          </tr>
        </thead>

        <tbody>
          <?php
            $old_read_states = array();
            while($paper = $arxiv_papers->fetch(PDO::FETCH_ASSOC)):
              if ($paper['read_pdf'] == '0'){
                $read_text = 'No';
                $set_read_color = "orange";
              }
              else {
                $read_text = 'Yes';
                $set_read_color = "green";
              }
              // MySQL table
              echo '<tr>';
              echo "<td>".$paper['id']."</td>";
              echo '<td><a href="'.$paper['abs_url'].'">'.$paper['title'].'</a></td>';
              echo '<td>'.$paper['visit_time'].'</td>';
              echo '<td><a class="z-depth-0 waves-effect waves-light btn modal-trigger light-blue lighten-4 black-text" href="#absmodal_'.$paper['id'].'">View</a></td>';
              // not authorized
              if(!isset($_SESSION['authorized'])){
                echo '<td><a class="unauth-button btn modal-trigger z-depth-0 white-text lighten-1 '.$set_read_color.'" href="#unauthorized_modal">'.$read_text.'</a></td>';
                echo '<td><a class="unauth-button btn modal-trigger z-depth-0 red-text transparent" href="#unauthorized_modal">Remove</a></td>';
              }
              // authorized, guest
              elseif(isset($_SESSION['authorized']) && $_SESSION['user']=="guest"){
                echo '<td><form method="post" class="read-btn"><input class="btn z-depth-0 white-text lighten-1 '.$set_read_color.'" type="submit" name="read_state_'.$paper['id'].'" value="'.$read_text.'"/></form></td>';
                echo '<td><a class="unauth-button btn modal-trigger z-depth-0 red-text transparent" href="#guest_modal">Remove</a></td>';
              }

              // authorized, not guest
              elseif(isset($_SESSION['authorized']) && $_SESSION['user']!="guest"){
                echo '<td><form method="post" class="read-btn"><input class="btn z-depth-0 white-text lighten-1 '.$set_read_color.'" type="submit" name="read_state_'.$paper['id'].'" value="'.$read_text.'"/></form></td>';
                echo '<td><form method="post" class="remove-btn"><input class="btn z-depth-0 red-text transparent" type="submit" name="remove_'.$paper['id'].'" value="Remove"/></form></td>';
              }
              echo '</tr>';
              ?>
              <!-- Abstract Modal Contents -->
              <div class="modal" id="absmodal_<?=$paper['id']?>">
                <div class="modal-content">
                  <h6><b><?php echo $paper['title']; ?></b></h6>
                  <p> <?php echo $paper['abstract']; ?> </p>
                </div>
                <div class="modal-footer">
                  <a href="#!" class="modal-close blue btn-flat white-text">Got It!</a>
                </div>
              </div>
              <?php
              endwhile ?>
          </tbody>
        </table>
    </div>

    <div class="modal" id="unauthorized_modal">
      <div class="modal-content">
        <h4><b>Warning!</b></h4>
        <p>Editing the projects are reserved for the admin and guests with credentials.
        Please login or request access to use these features</p>
      </div>
      <div class="modal-footer">
        <a style="margin-right:12px;" href="index.php" class="modal-close red btn-flat white-text">Login</a>
        <a href="#!" class="modal-close light-blue darken-4 btn-flat white-text">Dismiss</a>
      </div>
    </div>

    <div class="modal" id="guest_modal">
      <div class="modal-content">
        <h5><b>Attention!</b></h5>
        <p>Guests are prevented from moving records for data security reasons. If you would like to observe this function please contact me.</p>
      </div>
      <div class="modal-footer">
        <a style="margin-right:12px;" href=about.php class="modal-close deep-purple darken-2 btn-flat white-text">CONTACT INFO</a>
        <a href="#!" class="modal-close light-blue darken-4 btn-flat white-text">OK</a>
      </div>
    </div>

    <?php
    date_default_timezone_set('America/Vancouver');
    $current_date = date("Y-m-d H:i:s"); // used for entering date of read log change

    $arxiv_papers -> execute();  // since PDOStatement can't be used once consumed, need to re-execute the statement before another loop
    $papers = $arxiv_papers->fetchAll(PDO::FETCH_ASSOC);
    foreach($papers as $paper){
      $previous_read_state = $paper['read_pdf'];

      if (isset($_POST['read_state_'.$paper['id']]) && 	isset($_SESSION['authorized'])) {
          if ($previous_read_state == '0') {
          $new_read_state = '1';
        }
        elseif ($previous_read_state == '1') {
          $new_read_state = '0';
          }
          // insert the record change into logs table
        $read_change_log_statement = $pdo->prepare("INSERT INTO arxiv_papers_log (log_type,paper_id,paper_title,arxivid,`from`,`to`,change_date,authorization,abs_url)
                                        VALUES (:log_type,:paper_id,:paper_title,:arxivid,:change_from,:change_to,:change_date,:auth,:url)");
        $read_change_log_statement -> execute([
          'log_type' => 'read state change',
          'paper_id' => $paper['id'],
          'paper_title' => $paper['title'],
          'arxivid' => $paper['arxivid'],
          'change_from' => $previous_read_state,
          'change_to' => $new_read_state,
          'change_date' => $current_date,
          'auth' => $_SESSION['user'],
          'url' => $paper['abs_url'],
        ]);

        // update the original papers table
        $update_read_arxiv_papers = $pdo->prepare("UPDATE arxiv_papers SET read_pdf=:new_read_state_update WHERE id=:paper_id_update");
        $update_read_arxiv_papers -> execute([
          'paper_id_update' => $paper['id'],
          'new_read_state_update' => $new_read_state,
        ]);
        echo '<script type="text/javascript">
                   window.location = "arxiv.php"
              </script>';
        }
        // if paper is removed with button
        if(isset($_POST['remove_'.$paper['id']]) && isset($_SESSION['authorized'])){
          $remove_statement = $pdo -> prepare("INSERT INTO arxiv_papers_log (log_type,paper_id,paper_title,arxivid,`from`,`to`,change_date,authorization,abs_url)
                                          VALUES (:log_type,:paper_id,:paper_title,:arxivid,:change_from,:change_to,:change_date,:auth,:url)");
          $remove_statement -> execute([
            'log_type' => 'remove paper',
            'paper_id' => $paper['id'],
            'paper_title' => $paper['title'],
            'arxivid' => $paper['arxivid'],
            'change_from' => NULL,
            'change_to' => NULL,
            'change_date' => $current_date,
            'auth' => $_SESSION['user'],
            'url' => $paper['abs_url'],
          ]);
          // delete record from original table
          $update_remove_arxiv_papers = $pdo->prepare("DELETE FROM arxiv_papers WHERE id=:paper_id_remove");
          $update_remove_arxiv_papers -> execute(['paper_id_remove' => $paper['id']]);
          echo '<script type="text/javascript">
                     window.location = "arxiv.php"
                </script>';
        }
      }
    ?>

  </main>

	<?php include('footer.html'); ?>
  <script type="text/javascript">
    $(document).ready(function(){
    $('.modal').modal({
      'opacity': 0.6
    });
  });
  </script>

</html>
