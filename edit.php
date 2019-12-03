<?php
$database = "ccps530j_dictionary";
$user = "******";
$password = "******";
$host = "localhost";

try {   
    $conn = new mysqli($host, $user, $password, $database);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $edit_sql = "SELECT `id`, `word`, `definition`, `audio_url`, `art_url`, `art_caption` FROM `search_result` WHERE id = '".$id."'";
        $result = $conn->query($edit_sql);
    }

    foreach ($result as $row)
    {
        $id = $row['id'];
        $word = $row['word'];
        $def = $row['definition'];
        $pron = $row['audio_url'];
        $pic = $row['art_url'];
        $cap = $row['art_caption'];
    }

    echo "<br><br><br>Edit the Record for Keyword: ";
    echo ucwords ($word);
    
    if(isset($_POST['new']) && $_POST['new']==1) {
        $def = $_POST['def'];
        $pic = $_POST['art_url'];
        $cap = $_POST['art_caption'];
        $id = $_POST['id'];
        
        
        $update_sql = ("UPDATE search_result SET definition = '$def', art_url = '$pic', art_caption = '$cap' WHERE id = '$id';");

        $res = mysqli_query($conn,$update_sql) or die(mysqli_error());
        echo "<meta http-equiv='refresh' content = '0;url=data_table.php'>";
        
        echo (" <div id='dialog' title='Note'> <p>Record Updated</p> </div>");

    }
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script> src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"</script> 
  <script> src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"</script>
  
    <!--JQuery Plugin for Popup Dialog: https://jqueryui.com/dialog/-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#dialog" ).dialog();
  } );
  </script>
  
  <link rel="stylesheet" href="myStyles.css">

  <title>Dictionary</title>

</head>


<body>

    <nav class="navbar navbar-expand-sm bg-light fixed-top">
        <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="dictionary.php">Dictionary</a></li>
            <li class="nav-item"><a class="nav-link" href="./data_table.php">Search History</a></li>        
        </ul>
    </nav>
    <br/>

    <form action="edit.php" method="POST" style="margin-bottom: 30px;">
        <input type="hidden" name="new" value="1">

        <input type="hidden" name="id" value="<?php echo $id;?>">

        Definition: <input type="text" name="def" value ="<?php echo $def;?>"><br />        
        Picture URL: <input type="text" name="art_url" value ="<?php echo $pic;?>"><br />
        
        Picture Caption: <input type="text" name="art_caption" value ="<?php echo $cap;?>"> <br />

        <input type="submit" value="Update!">

    </form>
    
    <?php       
    }catch(PDOException $e) 
        {
            print "Error!" . $e->getMessage() . "<br/>";
        }

    ?>


</body>
</html>