<?php
include('navbar.php');
include('materialize.php');
require_once("pdo.php");

// pagination stuff
$limitperpage = 20;
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
}
else { $page = 1; }
$start_each_page = ($page - 1) * $limitperpage;

// table query
$log_table = $pdo->prepare("SELECT log_id,log_type,paper_id,paper_title,arxivid,`from`,`to`,change_date,authorization,abs_url
  FROM arxiv_papers_log ORDER BY log_id DESC LIMIT $start_each_page, $limitperpage");
$log_table -> execute();

// pagination stuff
$count_rows_query = $pdo -> query("SELECT count(log_id) from arxiv_papers_log");
$count_rows = $count_rows_query -> fetchColumn();
$num_pagination_pages = ceil($count_rows/$limitperpage);

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

<html>
  <head>
    <style type="text/css">
      table{
        font-size: 15px;
      }
      .return-btn{
        margin-top: 10px;
        float: right;
      }
      .pagination {
        margin-left: 45%;
        margin-right: 35%;
        width: 20%;
        display: flex;
      }
      .title-col{
        text-align: center;
      }
    </style>
  </head>

<main>
  <div class="container">
  <a class="return-btn btn z-depth-0 black-text lime waves-effect waves-light" href="arxiv.php">return to papers</a>
  </div>

  <!-- Pagination -->
  <ul class="pagination">
   <li class="waves-effect"><a href="papers_log.php?page=<?= $prev_page; ?>"><i class="material-icons">chevron_left</i></a></li>
   <?php
   for($page_index=1; $page_index <= $num_pagination_pages; $page_index++):
    if($page == $page_index) {
      $class_active = 'active lime'; }
    else {
      $class_active = '';
    } ?>
    <li class="<?= $class_active ?> waves-effect"><a href="papers_log.php?page=<?= $page_index; ?>"><?= $page_index; ?></a></li>
  <?php endfor ?>
   <li class="waves-effect"><a href="papers_log.php?page=<?= $next_page; ?>"><i class="material-icons">chevron_right</i></a></li>
  </ul>

  <div class="container">
    <table class="responsive-table striped">
      <thead>
        <tr>
          <th class='log-id-col'>Log Id</th>
          <th class='log-type-col'>Log Type</th>
          <th class='paper-id-col'>Paper Id</th>
          <th class='from-col'>Changed From</th>
          <th class='to-col'>Changed To</th>
          <th class='entry-date-col'>Entry Date</th>
          <th class='auth-col'>Authorization</th>
          <th class='title-col'>Title</th>
          <th class='remove-col'></th>
        </tr>
      </thead>

      <tbody>
        <?php
          while($log = $log_table->fetch(PDO::FETCH_ASSOC)):
            // restore if log type is paper removal
            if($log['log_type'] == 'remove paper'){
              $restore_option = true;
            }
            else{
              $restore_option = false;
            }
            // if change from and to are NULL fill with N/A
            if($log['from'] == NULL && $log['to'] == NULL){
              $change_from = 'N/A';
              $change_to = 'N/A';
            }
            else{
              $change_from = $log['from'];
              $change_to = $log['to'];
            }
            // table
            echo '<tr>';
            echo "<td>".$log['log_id']."</td>";
            echo '<td>'.$log['log_type'].'</td>';
            echo "<td>".$log['paper_id']."</td>";
            echo '<td>'.$change_from.'</td>';
            echo "<td>".$change_to."</td>";
            echo '<td>'.$log['change_date'].'</td>';
            echo '<td>'.$log['authorization'].'</td>';
            echo '<td><a href="'.$log['abs_url'].'">'.$log['paper_title'].'</a></td>';
            if($restore_option){
              if(!isset($_SESSION['authorized'])){
                echo '<td><a class="btn modal-trigger z-depth-0 white-text lime darken-4" href="#unauthorized_modal">Restore</a></td>';
              }
              else{
                  echo '<td><form method="post" class="restore-btn"><input class="btn z-depth-0 white-text lime darken-4"
                  type="submit" name="restore_'.$log['paper_id'].'" value="Restore"/></form></td>';
              }
            }
            else{
            echo "<td></td>";
            }
            echo '</tr>';
            endwhile
            ?>
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

  <?php

  date_default_timezone_set('America/Vancouver');
  $current_date = date("Y-m-d H:i:s"); // used for entering date of restore log
  $log_table -> execute(); // since PDOStatement can't be used once consumed, need to re-execute the statement before another loop
  while($log = $log_table->fetch(PDO::FETCH_ASSOC)){
    if(isset($_POST['restore_'.$log['paper_id']])){
      // restore the paper back to original from backup using arxivid NOT paper id (will get a new value when inserted into arxiv_papers)
      $restore_statement = $pdo->prepare("INSERT INTO arxiv_papers SELECT * FROM papers_backup WHERE arxivid=:log_arxivid");
      $restore_statement -> execute([
        'log_arxivid' => $log['arxivid'],
      ]);

      // create log record of restoration
      $restore_log_stmnt = $pdo-> prepare("INSERT INTO arxiv_papers_log (log_type,paper_id,paper_title,arxivid,`from`,`to`,change_date,authorization,abs_url)
                                      VALUES (:log_type,:paper_id,:paper_title,:arxivid,:change_from,:change_to,:change_date,:auth,:url)");
      $restore_log_stmnt -> execute([
        'log_type' => 'restore paper',
        'paper_id' => $log['paper_id'],
        'paper_title' => $log['paper_title'],
        'arxivid' => $log['arxivid'],
        'change_from' => NULL,
        'change_to' => NULL,
        'change_date' => $current_date,
        'auth' => $_SESSION['user'],
        'url' => $log['abs_url'],
        ]);

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
