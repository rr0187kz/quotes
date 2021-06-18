<?php $page_title = ' Quote Split'; ?>
<?php
  $nav_selected = "LIST";
  $left_buttons = "NO";
  $left_selected = "";
  require 'db_credentials.php';
  include("./nav.php");
	//error_reporting(0);
	include ("puzzlemaker.php");
?>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<?php
  include_once 'db_credentials.php';
  $sql = "SELECT * FROM quote_table WHERE id = '-1'";
  $db->set_charset("utf8");
  $touched=isset($_POST['ident']);

  if (!$touched) {
    echo 'You need to select an entry. Go back and try again. <br>';
?>
<button><a class="btn btn-sm" href="admin.php">Go back</a></button>
<?php
  }else {
    $id = $_POST['ident'];
    $sql = "SELECT * FROM quote_table WHERE id = '$id'";
  }
  //set result variable
  if (!$result = $db->query($sql)) {
    die ('There was an error running query[' . $connection->error . ']');
  }

  $nochars=3;
  echo '<h2 id="title">Split Quote</h2><br>';
  $sql = "SELECT * FROM preferences WHERE name = 'DEFAULT_CHUNK_SIZE'";
  if (!$result2 = mysqli_query($db,$sql)) {
    die ('There was an error running query[' . $connection->error . ']');
  }

  while ($row2 = mysqli_fetch_array($result2)){
	   $nochars=$row2["value"];
   }

  if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()){
        $quoteline = $row["quote"];
      }
    }

  $sql = "SELECT * FROM preferences WHERE name = 'KEEP_PUNCTUATION_MARKS'";
  if (!$result3 = mysqli_query($db,$sql)) {
    die ('There was an error running query[' . $connection->error . ']');
  }

  if($result3->num_rows > 0){
    $row = mysqli_fetch_array($result3);
  }

  if(isset($quoteline)){
    //Check whether punctuations marks should be kept or discarded
    if($row['value'] == "FALSE"){
      $regex = '/[^a-z\s]/i';
      $quoteline = preg_replace($regex, '', $quoteline);
    };

    SplitMaker($quoteline,$nochars);
  }
?>
