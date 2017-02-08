<!DOCTYPE html>
<html>
<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">

<!----------------Include another .php file ------->
<?php include 'tables.php';?>


<!----------php code to make the title the name user submits --------->
<!----------$post = false is used for an if statement later, so the bottom title only shows AFTER A SUBMIT -------->
<?php
  $title = "Charts are Love, Charts are Life";
  $post = false;
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $post = true;
    $title = $_POST["title"];
  }
?>

<!---------------head of the file, uses php to put title on the screen -------->
<head>
  <title><?php echo $title; ?></title>
</head>

<body>

<!-------- main header, equiv. to "Bob's chart-o-matic" ------------>
<h1>
    Charts are Love, Charts are Life
</h1>

<!-------------- form, a HTML way to get user input with text fields and buttons and the lot --------->
<!-------------- first one is checking the title, to see if they input a new title before they click submit --------->
<form enctype="multipart/form-data" method="post";>
  Name / Title: <input type="text" name="title" value="<?php if ($title != "Charts are Love, Charts are Life") { echo $title; } ?>"> <br>

<!--------------drop down menu ---------->
  Chart Type:
  <select name="chartType">
    <option value = "None"> None </option>
    <option value = "Asterisk"> Asterisk </option>
    <option value = "SVG Bar"> SVG BAR </option>
    <option value = "Pie"> Pie </option>
  </select>
  <br>

<!----------drop down menu ------------>
  Sort By:
  <select name="sortType">
    <option value = "None"> None </option>
    <option value = "Score"> Score </option>
    <option value = "Name"> Name </option>
    <option value = "Last Name"> Last Name </option>
  </select>
  <br>

<!---------textarea / box ---------->
  Data:
  <textarea name="gradeData" rows="5" cols="50" placeholder="Please enter the names and grades seperated by a comma..."><?php echo $_POST['gradeData'];
      if (!empty(['gradeData']) && $_FILES['csvfile']['error'] == 0)
      {
        echo "\n";
      }
      if ($_FILES['csvfile']['error'] == 0)
      {
        echo file_get_contents($_FILES['csvfile']['tmp_name']);
      }
    ?></textarea>
  <br>

  <input name="csvfile" type="file" />
  <br>

<!------------ button at the end, that submits and then calls functions on the extra .php file --------->
  <input type="submit" name="precious" value="Submit">
</form>

<!--------formatting a layout kinda? ---------->
<div style ="background-color: black; width=10;">
  <br>
</div>

<!--------- if statement, that makes a title only show on the bottom when the user submits a title ------->
<h1>
  <?php if ($post) {echo $title; } ?>
</h1>

<!----------calls function on the included .php file ----------->
<?php
    display();
?>

</body>
</html>
