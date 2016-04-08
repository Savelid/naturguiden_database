<?php
include 'res/logintodb.inc.php';

// Add group to database
if (isset($_GET['post']) && $_GET['post'] == 'group') {

	if(isset($_POST['id']) && $_POST['id'] != ''){
		$id = "id = '" . $_POST['id'] . "',";
	}else {
		$id = '';
	}

	$creator = $_SESSION['username'];

	$sql_insert = "INSERT INTO groups
					SET
					$id
					creator = '$creator',
					group_number = '$_POST[group_number]',
					group_name = '$_POST[group_name]',
					start_date = '$_POST[start_date]',
					end_date = '$_POST[end_date]',
					confirmed = '$_POST[confirmed]',
					comfort = '$_POST[comfort]',
					group_type = '$_POST[group_type]',
					group_skill = '$_POST[group_skill]',
					transportation = '$_POST[transportation]',
					comment = '$_POST[comment]'

					ON DUPLICATE KEY UPDATE

					group_number = '$_POST[group_number]',
					group_name = '$_POST[group_name]',
					start_date = '$_POST[start_date]',
					end_date = '$_POST[end_date]',
					confirmed = '$_POST[confirmed]',
					comfort = '$_POST[comfort]',
					group_type = '$_POST[group_type]',
					group_skill = '$_POST[group_skill]',
					transportation = '$_POST[transportation]',
					comment = '$_POST[comment]';";

	if ($conn->query($sql_insert) === TRUE) {
		$new_id = $conn->insert_id;

		echo "Error1 ";
		$_SESSION['showalert'] = 'true';
		$_SESSION['alert'] = 'Group added to database';

		if($new_id > 0){
			header("Location: admin_edit_groups.php?id=" . $new_id);
		}elseif (isset($_POST['id']) && $_POST['id'] != '') {
			header("Location: admin_edit_groups.php?id=" . $_POST['id']);
		}else {
			echo "New group created successfully, but redirect failed. ";
			echo " New id: " . $new_id;
		}
		die();
	} else {
		echo "Error: " . $sql_insert . "<br>" . $conn->error;
	}
}
// Add guest to database
if (isset($_GET['post']) && $_GET['post'] == 'guest') {

	if(isset($_POST['update_guest_id']) && $_POST['update_guest_id'] != ''){
		$id = "id = '" . $_POST['update_guest_id'] . "',";
	}else {
		$id = '';
	}

		$sql_insert = "INSERT INTO guests
						SET
						$id
						name = '$_POST[name]',
						group_id = '$_POST[group_id]',
						arrival_info = '$_POST[arrival_info]',
						return_info = '$_POST[return_info]',
						shoe_size = '$_POST[shoe_size]',
						accommodation = '$_POST[accommodation]',
						food = '$_POST[food]',
						age = '$_POST[age]',
						agent = '$_POST[agent]',
						payed = '$_POST[payed]',
						comment = '$_POST[comment]'

						ON DUPLICATE KEY UPDATE

						name = '$_POST[name]',
						group_id = '$_POST[group_id]',
						arrival_info = '$_POST[arrival_info]',
						return_info = '$_POST[return_info]',
						shoe_size = '$_POST[shoe_size]',
						accommodation = '$_POST[accommodation]',
						food = '$_POST[food]',
						age = '$_POST[age]',
						agent = '$_POST[agent]',
						payed = '$_POST[payed]',
						comment = '$_POST[comment]'
						";

		if ($conn->query($sql_insert) === TRUE) {
			echo "New guest created successfully, but redirect failed";
			$_SESSION['showalert'] = 'true';
			$_SESSION['alert'] = 'Guest added to the group';
			header("Location: admin_edit_groups.php?id=" . $_POST['group_id']);
			die();
		} else {
			echo "Error: " . $sql_insert . "<br>" . $conn->error;
		}
}
// Delete guest from database
if (isset($_GET['post']) && $_GET['post'] == 'delete_guest') {

		$sql_del_guest = "DELETE FROM guests
						WHERE id = '$_POST[id]';";
		if ($conn->query($sql_del_guest) === TRUE) {
			echo "Guest deleted, but redirect failed";
			$_SESSION['showalert'] = 'true';
			$_SESSION['alert'] = 'Guest deleted from the group';
			header("Location: admin_edit_groups.php?id=" . $_GET['id']);
			die();
		} else {
			echo "Error: " . $sql_insert . "<br>" . $conn->error;
		}
}
// Delete group from database
if (isset($_GET['post']) && $_GET['post'] == 'delete_group') {

		$sql_del_group = "DELETE FROM guests
											WHERE group_id = '$_POST[id]';

											DELETE FROM groups
											WHERE id = '$_POST[id]';
											";
		if ($conn->multi_query($sql_del_group) === TRUE) {
			echo "Guest deleted, but redirect failed";
			$_SESSION['showalert'] = 'true';
			$_SESSION['alert'] = 'Group deleted';
			header("Location: admin_view_groups.php");
			die();
		} else {
			echo "Error: " . $sql_insert . "<br>" . $conn->error;
		}
}

// Show informatin to edit guest
if (isset($_GET['guest_id'])) {

		$sql_show_guest_to_edit = "SELECT * FROM guests WHERE id = '$_GET[guest_id]'";

		$result_show_guest_to_edit = $conn->query($sql_show_guest_to_edit);
		if (!$result_show_guest_to_edit) {
			die("Group Query failed! " . $sql_show_guest_to_edit . "<br>" . $conn->error);
		}
		$guest = $result_show_guest_to_edit->fetch_array(MYSQLI_ASSOC);
}

if (isset($_GET['id'])) {

	$agent = '';
	$creator = '';
	$or_open = '';
	if($_SESSION['username'] != $superuser){
		$agent = "AND agent = '" . $_SESSION['username'] . "'";
		$creator = "WHERE creator = '" . $_SESSION['username'] . "'";
		$or_open = "OR group_type = 'Open group'";
	}

	$sql = "SELECT *
	FROM groups
	WHERE id = '$_GET[id]';";
	$result = $conn->query($sql);
	if (!$result) {
		die("Group Query failed! " . $sql . "<br>" . $conn->error);
	}
	$group = $result->fetch_array(MYSQLI_ASSOC);

	$sql = "  SELECT *
	FROM guests
	WHERE group_id = '$_GET[id]'
	$agent
	ORDER BY name DESC";
	$guest_results = $conn->query($sql);
	if (!$guest_results) {
		echo $sql . "<br><br>" . $conn->error;
		die("Guests Query failed!");
	}
}
$conn->close();

$titel = 'Edit group';
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

<section class="content">

	<form action= <?php echo htmlspecialchars('admin_edit_groups.php?post=group'); ?> method="post" class="form-horizontal" id="edit_group_form">

		<?php
		if(isset($_GET['id'])){
			echo '<input type="hidden" class="form-control" name="id" value="' . $_GET['id'] . '"/>';
		}
		?>
		<div class="row">
			<div class="col-xs-8 col-xs-offset-4 col-md-10 col-md-offset-2"><h4>Group</h4></div>
		</div>
		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<label for="group_number" class="col-xs-4 control-label">Group number</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="group_number" <?= !empty($group['group_number']) ?  'value="' . $group['group_number'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="group_name" class="col-xs-4 control-label">Group name</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="group_name" <?= !empty($group['group_name']) ?  'value="' . $group['group_name'] . '"' : '' ; ?>>
					</div>
				</div>
<?php
	$select_is_open = '';
	$select_is_private = '';
	if(isset($group['group_type']) && $group['group_type'] == 'Open group'){
		$select_is_open = 'selected';
	}else{
		$select_is_private = 'selected';
	}
?>
				<div class="form-group">
					<label for="group_type" class="col-xs-4 control-label">Group type</label>
					<div class="col-xs-8">
						<select class="form-control" name="group_type">
						  <option value="Open group" <?php echo $select_is_open;?>>Open group</option>
						  <option value="Private group" <?php echo $select_is_private;?>>Private group</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="group_skill" class="col-xs-4 control-label">Group skill</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="group_skill" <?= !empty($group['group_skill']) ?  'value="' . $group['group_skill'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="confirmed" class="col-xs-4 control-label">Confirmed</label>
					<div class="col-xs-8">
						<input type="hidden" class="form-control" name="confirmed" value="false"/>
						<input type="checkbox" class="checkbox" name="confirmed" value="true" <?= !empty($group['confirmed']) && $group['confirmed'] == 'true' ?  'checked' : '' ; ?>>
					</div>
				</div>

			</div>
			<div class="col-md-6">

				<div class="form-group">
					<label for="start_date" class="col-xs-4 control-label">Start date</label>
					<div class="col-xs-8">
						<input type="date" class="form-control" name="start_date" <?= !empty($group['start_date']) ?  'value="' . $group['start_date'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="end_date" class="col-xs-4 control-label">End date</label>
					<div class="col-xs-8">
						<input type="date" class="form-control" name="end_date" <?= !empty($group['end_date']) ?  'value="' . $group['end_date'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="comfort" class="col-xs-4 control-label">Comfort level</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="comfort" <?= !empty($group['comfort']) ?  'value="' . $group['comfort'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="transportation" class="col-xs-4 control-label">Transportation</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="transportation" <?= !empty($group['transportation']) ?  'value="' . $group['transportation'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="comment" class="col-xs-4 control-label">Comment</label>
					<div class="col-xs-8">
						<textarea class="form-control" rows="3" name="comment"><?= !empty($group['comment']) ?  $group['comment'] : '' ; ?></textarea>
					</div>
				</div>

			</div>
		</div>
	</form>
<?php
	if(isset($_GET['id'])):
?>
	<form action="<?php echo htmlspecialchars('admin_edit_groups.php?post=delete_group')?>" method="post" id="delete_group_form">
	<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
	</form>

		<div class="row">
			<div class="col-sm-12">

				<button type="submit" class="btn btn-default" form="edit_group_form">Update Group</button>
				<button type="submit" class="btn btn-default pull-right" form="delete_group_form">Delete</button>

			</div>
		</div>
<?php
	else:
?>
		<div class="row">
			<div class="col-sm-12">

				<button type="submit" class="btn btn-default" form="edit_group_form">Create Group</button>
				<a href="admin_view_groups.php" class="btn btn-default pull-right">Back to View</a>

			</div>
		</div>
<?php
	endif;
?>
</section>
<?php
	if(isset($_GET['id'])):
?>

<section class="content">

<?php

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
		<th>Edit</th>
		<th>Del</th>
		</tr>
		</thead>
		<tbody>';

		// %3$s will be replaced with variables later
		$path = "admin_edit_groups.php?id=" . $_GET['id'] . "&post=delete_guest";
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
		<td> <a href="admin_edit_groups.php?id=%11$s&guest_id=%10$s">Edit</a> </td>
		<td>
			<form action="' . htmlspecialchars($path) . '" method="post" onsubmit="return confirm(\'Delete the guest?\');">
			<input type="hidden" name="id" value="%10$s" />
			<input type="submit" class="submitLink" value="X">
			</form>
		</td>

		</tr>';

		$table_footer = '</tbody></table>';

		if ($guest_results->num_rows > 0) {

			echo $table_header;

			// output data of each row
			while($guest_row = $guest_results->fetch_assoc()) {

				echo sprintf($table_row_formating,
				$guest_row["name"],
				$guest_row["arrival_info"],
				$guest_row["return_info"],
				$guest_row["shoe_size"],
				$guest_row["accommodation"],
				$guest_row["food"],
				$guest_row["age"],
				$agent_names[$guest_row["agent"]],
				$guest_row["payed"],
				$guest_row["id"],
				$_GET["id"]
				);
				if($guest_row["comment"] != ''){
					echo '<tr><td colspan=11> ';
					echo $guest_row["comment"];
					echo ' </td></tr>';
				}
			}

			echo $table_footer;

		} else {
			echo "No guests";
		}
?>
	<form action= <?php echo htmlspecialchars('admin_edit_groups.php?post=guest'); ?> method="post" class="form-horizontal">
		<?php if(isset($_GET['guest_id'])){
			echo '<input type="hidden" name="update_guest_id" value="' . $_GET["guest_id"] . '"/>';
		}?>
		<input type="hidden" name="group_id" value="<?php echo $_GET['id'];?>"/>
		<input type="hidden" name="agent" value="<?php echo $_SESSION['username'];?>"/>

		<div class="row">
			<div class="col-xs-8 col-xs-offset-4 col-md-10 col-md-offset-2"><h4>New Guest</h4></div>
		</div>
		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<label for="name" class="col-xs-4 control-label">Name</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="name" <?= !empty($guest['name']) ?  'value="' . $guest['name'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="arrival_info" class="col-xs-4 control-label">Arrival info</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="arrival_info" <?= !empty($guest['arrival_info']) ?  'value="' . $guest['arrival_info'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="return_info" class="col-xs-4 control-label">Return info</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="return_info" <?= !empty($guest['return_info']) ?  'value="' . $guest['return_info'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="shoe_size" class="col-xs-4 control-label">Shoe size</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="shoe_size" <?= !empty($guest['shoe_size']) ?  'value="' . $guest['shoe_size'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="accommodation" class="col-xs-4 control-label">Accommodation</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="accommodation" <?= !empty($guest['accommodation']) ?  'value="' . $guest['accommodation'] . '"' : '' ; ?>>
					</div>
				</div>

			</div>
			<div class="col-md-6">

				<div class="form-group">
					<label for="food" class="col-xs-4 control-label">Food</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="food" <?= !empty($guest['food']) ?  'value="' . $guest['food'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="age" class="col-xs-4 control-label">Age</label>
					<div class="col-xs-8">
						<input type="number" class="form-control" name="age" <?= !empty($guest['age']) ?  'value="' . $guest['age'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="payed" class="col-xs-4 control-label">Payed</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="payed" <?= !empty($guest['payed']) ?  'value="' . $guest['payed'] . '"' : '' ; ?>>
					</div>
				</div>

				<div class="form-group">
					<label for="comment" class="col-xs-4 control-label">Comment</label>
					<div class="col-xs-8">
						<textarea class="form-control" rows="3" name="comment"><?= !empty($guest['comment']) ? $guest['comment'] : '' ; ?></textarea>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">

				<button type="submit" class="btn btn-default"><?= !empty($_GET['guest_id']) ? 'Update Guest' : 'Add Guest' ; ?></button>
				<a href="admin_view_groups.php" class="btn btn-default pull-right">Back to View</a>

			</div>
		</div>
	</form>
</section>

<?php
endif;
include 'res/footer.inc.php'; ?>
