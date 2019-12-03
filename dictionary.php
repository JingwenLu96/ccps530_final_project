<?php 
  $database = "ccps530j_dictionary";
  $user = "******";
  $password = "******";
  $host = "localhost";

    if($_POST['word']){  
        
      // Create connection
      $conn = new mysqli($host, $user, $password, $database);

      // Check connection
      //if ($conn->connect_error) {
        // die("Connection failed: " . $conn->connect_error);
      //}
      //echo "Connected successfully";
      
      $word = $_POST['word'];
      $word = strtolower($word);

      $handle = curl_init();
      $key = "2f7e335a-c730-4f28-aebe-92e89473ebfb";
      $url = "https://www.dictionaryapi.com/api/v3/references/collegiate/json/$word?key=".$key;


      // Set the url
      curl_setopt($handle, CURLOPT_URL, $url);
      // Set the result output to be a string.
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($handle);
      curl_close($handle); //get back a json file
      //convert json to array
      $arr = json_decode($output, true);

      
      
      $looksql = "SELECT `id`, `word`, `definition`, `audio_url`, `art_url`, `art_caption` FROM `search_result` WHERE word like '".$_POST['word']."'";
      $db_result = $conn->query($looksql);

      
      if ($db_result->num_rows > 0) {
    // output data of each row
        while($row = $db_result->fetch_assoc()) {
            $definition = $row['definition'];
            $audio_url = $row['audio_url'];
            $art_url = $row['art_url'];
            $art_caption = $row['art_caption'];
            //echo "definition: " . $row["definition"]. " - Picture: " . $row["art_url"]. " " . $row["audio_url"]. "<br>";
        }
      }
      else
      {
        //echo "Word doesn't exist.";
        $audio_url = "https://media.merriam-webster.com/soundc11/$word[0]/";
        $audio_file = $arr[0][hwi][prs][0][sound][audio].".wav";
        $audio_url = $audio_url.$audio_file;

        $definition = $arr[0][def][0][sseq][0][0][1][dt][0][1];

        $art_url = "http://www.merriam-webster.com/assets/mw/static/art/dict/";
        $artid = $arr[0][art][artid];
        $art_url =$art_url.$artid.".gif";
        $art_caption = $arr[0][art][capt];
     
        $art_caption = parse($art_caption); 
        if ($artid !== NULL) { 
            $sql = "INSERT INTO `search_result` (`id`, `word`, `definition`, `audio_url`, `art_url`, `art_caption`) VALUES (NULL, '$word', '$definition', '$audio_url', '$art_url', '$art_caption');";
          
            if ($conn->query($sql) == TRUE) {
              //echo "New record created successfully, you can check your search history in the second tab.";
            } else {
              echo "Error: <br>" . $conn->error;
            }
        }   
        else {
            $art_url = NULL; 
            $sql = "INSERT INTO `search_result` (`id`, `word`, `definition`, `audio_url`, `art_url`, `art_caption`) VALUES (NULL, '$word', '$definition', '$audio_url', '$art_url', '$art_caption');";
          
            if ($conn->query($sql) == TRUE) {
              //echo "New record created successfully, you can check your search history in the second tab.";
            } else {
              echo "Error: <br>" . $conn->error;
            }
        }
    echo ("<div id='dialog' title='Note'>
        <p>A new word has been added to your database. You can check it on the 'Search History' tab.</p></div>");

      }


          
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
    <li class="nav-item active"><a class="nav-link" href="#">Dictionary</a></li>
    <li class="nav-item"><a class="nav-link" href="./data_table.php">Search History</a></li>        
  </ul>
</nav>
<br/>

<div class="container">
  <div class="page-header">
    <br>
    <h1>Input Word</h1>
  </div>
  <div class="row">
      <div class="span8">
      <form action="dictionary.php" method="post">
        <input type="text" class="span6" name="word" id="word" value="<?php echo$_POST['word'];?>">
        <input type="submit" name="submitBtn" value="Translate">
      </form>
    </div>
  </div>

<?php 
function parse($value) {
  $findAndReplace = [
      '{it}' => '<i>',
      '{/it}' => '</i>',
      '{bc}' => ' ',
      '{sup}' => '<sup>',
      '{/sup}' => '</sup>',
      '{inf}' => '<sup>',
      '{/inf}' => '</sup>'
  ];

  return str_replace(array_keys($findAndReplace), array_values($findAndReplace), $value);
}

if($_POST['word']){ 
  echo("
  <br/> 
  <div class='def'>
  <b>Definition:</b> 
  </div>
  ");
  echo parse($definition);

  echo("
  <br/>
  <div class='row'>
  <audio controls>
    <source src='$audio_url' type='audio/wav'>
  Your browser does not support the audio element.
  </audio>
  </div>
  ");

      if (strpos($art_url, $word) == true || strpos($art_url, 'merriam-webster') == false ){
      echo("
      <br/>
      <div class='cap'>
      <img src='$art_url' width='400'>
      <br/>
      <b>Caption: </b>
      </div>
      ");
      echo parse($art_caption);
      }

}
?>

</div>
<br />
<br />
<footer><small>Copyright &copy; Jingwen Lu,2019</small></footer>

</body>
</html>