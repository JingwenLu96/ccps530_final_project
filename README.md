# Final Project: Interactive Dictionary 
Name: Jingwen Lu    
Online Demo: http://ccps530jl.com/dictionary/   
License: MIT Licence 

## Getting Started
This instruction will guide the reader through processes of building the project, including:  
* A dictionary search page
* A data table displays the search history
* Having the functionality of editing or deleting records 


## Flow
1. User searches a keyword in the search page.
2. The definition, visualization and caption for the visual image of the keyword will be displayed on the same page.
3. The search result is saved into a seperate data table which can be accessed on the tab called 'Search History'.
4. User is able to edit/delete the searched result in the 'Search History' table.

## Included Components 
API:  
[Merriam-Webster Dictionary API](https://dictionaryapi.com/) 

JQuery Plugins:  
[Light Box](http://fancyapps.com/fancybox/3/) 
[Dialog Box](https://jqueryui.com/dialog/)

Bootstrap 4

## Steps 

### Title Page
Create a title page by using Bootstrap 4 components

* Create the Navigation bar fixed to the top 

``` 
    <nav class="navbar navbar-expand-sm bg-light fixed-top">
        <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="dictionary.php">Dictionary</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Search History</a></li>        
        </ul>
    </nav>    
 ```
 * Design the title page as you wish, I have used the Jumbotron component and added a button on top
 ```
     <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1>Your Personalized Dictionary</h1><br />
                <a href="dictionary.php" class="btn btn-primary">Start</a>
            </div>
    </div>
```
### Search Page 
Please note you have to be connected to a database for full functionality 
* PHP file for database connection and API access
```
  <?php
  //Please connect to a database before going further 
  
  //API Access
      if($_POST['word']){  
            
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
    
  //Check whether the searched word is included in the database or not:
    If so, calling the data from database instead from API, 
    If not, getting the information from API and inserting a new record into database with SQL command
      
        //sample of access information from API
        $audio_url = "https://media.merriam-webster.com/soundc11/$word[0]/";
        $audio_file = $arr[0][hwi][prs][0][sound][audio].".wav";
        $audio_url = $audio_url.$audio_file;

        $definition = $arr[0][def][0][sseq][0][0][1][dt][0][1];

        $art_url = "http://www.merriam-webster.com/assets/mw/static/art/dict/";
        $artid = $arr[0][art][artid];
        $art_url =$art_url.$artid.".gif";
        $art_caption = $arr[0][art][capt];
     
        // popup note for adding new record
        echo ("<div id='dialog' title='Note'>
          <p>A new word has been added to your database. You can check it on the 'Search History' tab.</p></div>");
  ?>
```
* In HTML file, print each component of definition defined in PHP file accordingly. 
### Data Table Page
  
* Print Search History table by using data fields from the database  
* Adding EDIT and DELETE columns to the table 

> note: used JQuery Plugin: [fancybox](http://fancyapps.com/fancybox/3/) for lightbox effect on pictures 


### Edit Record
* Set up the fields in data table that is avaliable for editing  
* Update the record from data table by using SQL command, UPDATE
```
  $update_sql = ("UPDATE search_result SET definition = '$def', art_url = '$pic', art_caption = '$cap' WHERE id = '$id';");

```
### Delete Record 
* Delete the record from data table by using SQL command, DELETE
```
  $del_sql = ("DELETE FROM search_result WHERE id = '$id';");

```

## Learn More
* [Bootstrap 4](https://www.w3schools.com/bootstrap4/default.asp)
* [JQuery UI](https://jqueryui.com/)
* [PHP MySQL Database](https://www.w3schools.com/php/php_mysql_intro.asp)










