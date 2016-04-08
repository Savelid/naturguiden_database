<?php
include 'res/logintodb.inc.php';

$titel = 'View groups';
include 'res/header.inc.php';
?>

  <?php
  if(isset($_SESSION['alert']) && isset($_SESSION['showalert']) && $_SESSION['showalert'] == 'true') {
    $_SESSION['showalert'] = 'false';
    echo '
    <section class="content hidden-print">
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    ';
    echo $_SESSION['alert'];
    echo '
    </div>
    </section>
    ';
  }
  ?>

      <?php
      // %s will be replaced with variables later

      $group_row_formating = '
      <section class="content">
      <table class="table table-bordered table-responsive table_750" style="table-layout: fixed;">
      <thead>
      <tr>
        %1$s %3$s %2$s
        %1$s %4$s %2$s
        %1$s %5$s %2$s
        %1$s %6$s %2$s
      </tr>
      <tr>
        %1$s %7$s - %8$s %2$s
        %1$s %9$s %2$s
        %1$s %10$s %2$s
        %1$s Creator: %11$s, Confirmed: %12$s %2$s
      </tr>
      </thead>
      ';

      $table_header = '
      <table class="table table-striped table-bordered table-responsive table_750">
      <thead>
      <tr>
      <th>Name</th>
      <th>Arrival</th>
      <th>Depature</th>
      <th>Shoe size</th>
      <th>Accom.</th>
      <th>Food</th>
      <th>Age</th>
      <th>Agent</th>
      <th>Payed</th>
      </tr>
      </thead>
      <tbody>';

      // %3$s will be replaced with variables later
      $table_row_formating = '
      <tr>

      <td> %1$s </td>
      <td> %2$s </td>
      <td> %3$s </td>
      <td> %4$s </td>
      <td> %5$s </td>
      <td> %6$s </td>
      <td> %7$s </td>
      <td> %8$s </td>
      <td> %9$s </td>

      </tr>';

      $table_footer = '</tbody></table>';

      $agent = '';
      $creator = '';
      $or_open = '';
      if($_SESSION['username'] != $superuser){
        $agent = "AND agent = '" . $_SESSION['username'] . "'";
        $creator = "WHERE creator = '" . $_SESSION['username'] . "'";
        $or_open = "OR group_type = 'Open group'";
      }


      $sql = "  SELECT *
      FROM groups
      $creator
      $or_open
      ORDER BY start_date";
      $result_groups = $conn->query($sql);
      if (!$result_groups) {
        echo $sql . "<br><br>" . $conn->error;
        die("Groups Query failed!");
      }

      if ($result_groups->num_rows > 0) {
        // output data of each row
        while($group_row = $result_groups->fetch_assoc()) {

          echo sprintf($group_row_formating,
          '<th>',
          '&nbsp;</th>',
          $group_row["group_number"],
          $group_row["group_name"],
          $group_row["group_type"],
          $group_row["group_skill"],
          $group_row["start_date"],
          $group_row["end_date"],
          $group_row["comfort"],
          $group_row["transportation"],
          $agent_names[$group_row["creator"]],
          $group_row["confirmed"]
          );
          if($group_row["comment"] != ''){
            echo '<tbody><tr><td colspan=4>';
            echo $group_row["comment"];
            echo ' </td></tr></tbody>';
          }
          echo '</table>';

          $count_sql = "  SELECT *
          FROM guests
          WHERE group_id = $group_row[id]
          ORDER BY name DESC";
          $result_count = $conn->query($count_sql);
          if (!$result_count) {
            echo $count_sql . "<br><br>" . $conn->error;
            die("Count Query failed!");
          }
          $row_cnt = $result_count->num_rows;

          $guest_sql = "  SELECT *
          FROM guests
          WHERE group_id = $group_row[id]
          $agent
          ORDER BY name DESC";
          $result_guests = $conn->query($guest_sql);
          if (!$result_guests) {
            echo $guest_sql . "<br><br>" . $conn->error;
            die("Guest Query failed!");
          }

          echo "<p>This group has " . $row_cnt . " guests.</p>";

          if ($result_guests->num_rows > 0) {

            echo $table_header;

            // output data of each row
            while($guest_row = $result_guests->fetch_assoc()) {

              echo sprintf($table_row_formating,
              $guest_row["name"],
              $guest_row["arrival_info"],
              $guest_row["return_info"],
              $guest_row["shoe_size"],
              $guest_row["accommodation"],
              $guest_row["food"],
              $guest_row["age"],
              $agent_names[$guest_row["agent"]],
              $guest_row["payed"]
              );
              if($guest_row["comment"] != ''){
                echo '<tr><td colspan=9> ';
                echo $guest_row["comment"];
                echo ' </td></tr>';
              }
            }

            echo $table_footer;

          } else {
            echo "<p>There is no guests bound to you here</p>";
          }

          echo '<div class="row">';
      			echo '<div class="col-sm-12">';
      				echo '<a href="admin_edit_groups.php?id=' . $group_row['id'] . '" class="btn btn-default">Edit group</a>';
      			echo '</div>';
      		echo '</div>';

          echo '</section>';

        }
      } else {
        echo "<section> No groups </section>";
      }
      $conn->close();
      ?>

<?php include 'res/footer.inc.php'; ?>
