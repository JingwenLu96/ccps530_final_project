<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script> src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"</script> 
  <script> src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"</script>
  <!--JQuery Plugin for Display Image: http://fancyapps.com/fancybox/3/-->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

  <!--Font Awesome Toolkit -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <link rel="stylesheet" href="myStyles.css">

  <title>Dictionary</title>

</head>

<?php
$database = "ccps530j_dictionary";
$user = "******";
$password = "******";
$host = "localhost";
?>

<body>

    <nav class="navbar navbar-expand-sm bg-light fixed-top">
        <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="dictionary.php">Dictionary</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Search History</a></li>        
        </ul>
    </nav>
    <br/>

    <?php
        try {   
            $dbh = new PDO ("mysql:host=$host;dbname=$database", $user, $password);
            $result = $dbh->query('SELECT * from search_result');

            echo "<br><br><h2><center>Your Search History</center></h2> <br>";
    
    ?>

    <table class="table table-bordered" style="margin-bottom: 30px" align="center" border="1">
        <thead> 
            <tr> 
                <td width="20"> Word </td> 
                <td width="20"> Definition </td> 
                <td width="10"> Pronunciation </td> 
                <td width="10"> Picture </td>
                <td width="20"> Caption </td> 
                <td width="10"> Edit </td>
                <td width="10"> Delete </td>

            </tr>
        </thead>
   
        <?php
        foreach ($result as $row)
        {
            $id = $row['id'];
            $word = $row['word'];
            $def = $row['definition'];
            $pron = $row['audio_url'];
            $pic = $row['art_url'];
            $cap = $row['art_caption'];
        ?>
    <tbody>
        <tr>
            <td><? echo $word?></td>
            <td><? echo $def?></td>
            <td><? echo ("<div class='row'>
                            <audio controls>
                                <source src='$pron' type='audio/wav'>
                                    Your browser does not support the audio element.
                            </audio>
                        </div>")?></td>
            <td>
                <?
                echo ("<div class='cap'> <a data-fancybox='gallery' href='$pic'> <img src='$pic' width='200'> </a> </div>");
                ?>
            </td>
            <td><? echo $cap?></td>
            <td> <a href="edit.php?id=<?php echo $row["id"]; ?>"><i class="far fa-edit"></i></a> </td>
            <td> <a href="delete.php?id=<?php echo $row["id"]; ?>"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    </tbody>
    <? } ?>    

    </table>
    
    <?php       
    }catch(PDOException $e) 
        {
            print "Error!" . $e->getMessage() . "<br/>";
        }

    ?>

</body>
</html>