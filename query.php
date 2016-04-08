<?php
 header('Access-Control-Allow-Origin: *');
 include_once "res/config.inc.php";
?>
<?php

$conn = new mysqli($host, $username, $password, $db_name);
if ($conn->connect_error) {
  console.log('Database connection failed');
  die('Could not connect: ' . mysqli_error($conn));
}

echo '{';

$sql = "  SELECT * FROM news ORDER BY position, datetime DESC LIMIT 4";
$result = $conn->query($sql);
if (!$result) {
  echo $sql . "<br><br>" . $conn->error;
  die("Groups Query failed!");
}

if ($result->num_rows > 0) {
  echo '"news": [';

  $first = true;
  // output data of each row
  while($row = $result->fetch_assoc()) {

        if($first) {
            $first = false;
        } else {
            echo ',';
        }
        echo json_encode($row);
    }
    echo '],';
} else {
    echo '[]';
}



$sql = "  SELECT * FROM photos ORDER BY position, datetime DESC LIMIT 10";
$result = $conn->query($sql);
if (!$result) {
  echo $sql . "<br><br>" . $conn->error;
  die("Groups Query failed!");
}

if ($result->num_rows > 0) {
  echo '"photos": [';

  $first = true;
  // output data of each row
  while($row = $result->fetch_assoc()) {

        if($first) {
            $first = false;
        } else {
            echo ',';
        }
        echo json_encode($row);
    }
    echo ']';
} else {
    echo '[]';
}

echo '}';

$conn->close();
