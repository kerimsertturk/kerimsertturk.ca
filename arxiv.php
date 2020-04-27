<!DOCTYPE html>
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
      width: 600px;
      text-align: center;
    }
    .date-col{
      width: 130px;
      text-align: left;
    }
    .read-col{
      width:50px;
      text-align: left;
    }
    .abstract-col{
      width: 80px;
    }
    .pagination {
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

	<?php
  include('navbar.html');
  include('materialize.php');
  require_once("pdo.php");

  $limitperpage = 8;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  else { $page = 1; }

  $start_each_page = ($page - 1) * $limitperpage;
  $arxiv_papers = $pdo->prepare("SELECT id,title,visit_time,abs_url,read_pdf,abstract FROM arxiv_papers ORDER BY id DESC LIMIT $start_each_page, $limitperpage");
  $arxiv_papers -> execute();
  // for now vulnerable to injection, fix later
  //$arxiv_papers->execute(array(':start' => 0, ':lim' => 10));

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
    <div class="container col s12 l6 m4">
      <p>Last Updated on: </p>
    </div>
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
            <th class='read-col'>Read?</th>
            <th class='abstract-col'>Abstract</th>
          </tr>
        </thead>

        <tbody>
          <?php
            while($paper = $arxiv_papers->fetch(PDO::FETCH_ASSOC)):
              if ($paper['read_pdf'] == '0'){
                $read_text = 'No';
              }
              else {
                $read_text = 'Yes';
              }
              echo '<tr>';
              echo "<td>".$paper['id']."</td>";
              echo '<td><a href="'.$paper['abs_url'].'">'.$paper['title'].'</a></td>';
              echo '<td>'.$paper['visit_time'].'</td>';
              echo '<td>'.$read_text.'</td>';
              echo '<td><a class="waves-effect waves-light btn modal-trigger blue" href="#absmodal_'.$paper['id'].'">View</a></td>';
              echo '</tr>';
              ?>
              <!-- Abstract Modal Contents -->
              <div class="modal" id="absmodal_<?=$paper['id']?>">
                <div class="modal-content">
                  <h5>Abstract</h4>
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
