<?php
$database = "ccps530j_dictionary";
$user = "******";
$password = "******";
$host = "localhost";

$conn = new mysqli($host, $user, $password, $database);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $del_sql = ("DELETE FROM search_result WHERE id = '$id';");

        $res = mysqli_query($conn, $del_sql) or die(mysqli_error());
            
        echo "<meta http-equiv='refresh' content = '0;url=data_table.php'>";
 
        echo (" <div id='dialog' title='Note'> <p>Record Deleted</p> </div>");
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
  
    <!--JQuery Plugin for Popup Dialog-->
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

</html>