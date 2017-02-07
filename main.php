<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
<form method="post";>
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
  <textarea name="gradeData" rows="5" cols="50" placeholder="Please enter the names and grades seperated by a comma..."></textarea>
  <br>

<!------------ button at the end, that submits and then calls functions on the extra .php file --------->
  <input type="submit" name="precious" value="Submit">
</form>

<!--------formatting a layout kinda? ---------->
<div style ="background-color: black; width=10;">
  ayyyyyy
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
