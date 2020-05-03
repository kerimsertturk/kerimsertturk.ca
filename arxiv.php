<html>
<head>
  <style type="text/css">
    table{
      table-layout: fixed;
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
    .set-read{
      width:90px;
    }
    .remove{
      width:100px;
    }
    .pagination {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .update{
    display: inline;
    }
  </style>
</head>

	<?php
  include('navbar.html');
  include('materialize.php');
  require_once("pdo.php");

  $limitperpage = 10;
  if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
  }
  else { $page = 1; }

  $start_each_page = ($page - 1) * $limitperpage;
  $arxiv_papers = $pdo->prepare("SELECT id,title,visit_time,abs_url,read_pdf,abstract FROM arxiv_papers ORDER BY id DESC LIMIT $start_each_page, $limitperpage");
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
              echo '<td><a class="z-depth-0 waves-effect waves-light btn modal-trigger  light-blue lighten-4 black-text" href="#absmodal_'.$paper['id'].'">View</a></td>';
              echo '<td><form method="post" class="read-btn"><input class="btn z-depth-0 white-text lighten-1 '.$set_read_color.'" type="submit" name="read_state_'.$paper['id'].'" value="'.$read_text.'"/></form></td>';
              echo '<td><form method="post" class="read-btn"><input class="btn z-depth-0 white-text red lighten-1" type="submit" name="remove_'.$paper['id'].'" value="Remove"/></form></td>';
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

    <?php

    date_default_timezone_set('America/Vancouver');
    $current_date = date("Y-m-d H:i:s"); // used for entering date of read log change

    $arxiv_papers -> execute();  // since PDOStatement can't be used once consumed, need to re-execute the statement before another loop
    while($paper = $arxiv_papers->fetch(PDO::FETCH_ASSOC)){

      $previous_read_state = $paper['read_pdf'];

      if (isset($_POST['read_state_'.$paper['id']])) {
          if ($previous_read_state == '0') {
          $new_read_state = '1';
        }
        elseif ($previous_read_state == '1') {
          $new_read_state = '0';
          }
          // insert the record change into logs table
        $read_change_log_statement = $pdo->prepare("INSERT INTO arxiv_papers_log (log_type,paper_id,paper_title,`from`,`to`,change_date,abs_url)
                                        VALUES (:log_type,:paper_id,:paper_title,:change_from,:change_to,:change_date,:url)");
        $read_change_log_statement -> execute([
          'log_type' => 'read state change',
          'paper_id' => $paper['id'],
          'paper_title' => $paper['title'],
          'change_from' => $previous_read_state,
          'change_to' => $new_read_state,
          'change_date' => $current_date,
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
        if(isset($_POST['remove_'.$paper['id']])){
          $remove_statement = $pdo -> prepare("INSERT INTO arxiv_papers_log (log_type,paper_id,paper_title,`from`,`to`,change_date,abs_url)
                                          VALUES (:log_type,:paper_id,:paper_title,:change_from,:change_to,:change_date,:url)");
          $remove_statement -> execute([
            'log_type' => 'remove paper',
            'paper_id' => $paper['id'],
            'paper_title' => $paper['title'],
            'change_from' => NULL,
            'change_to' => NULL,
            'change_date' => $current_date,
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
