<!DOCTYPE html>
<html>

<?php include 'tables.php';?>

<?php
  $title = "Charts are Love, Charts are Life";
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $title = $_POST["title"];
  }
?>

<head>

  <title><?php echo $title; ?></title>

</head>

<body>

<h1>
    Charts are Love, Charts are Life
</h1>

<form method="post";>

  Name / Title: <input type="text" name="title" value="<?php if ($title != "Charts are Love, Charts are Life") { echo $title; } ?>"> <br>

  Chart Type:
  <select>
    <option value = "Stats"> Stats </option>
    <option value = "Bar"> Bar </option>
    <option value = "Line"> Line </option>
    <option value = "Pie"> Pie </option>
  </select>
  <br>

  Sort By:
  <select>
    <option value = "None"> None </option>
    <option value = "Score"> Score </option>
    <option value = "Name"> Name </option>
    <option value = "Last Name"> Last Name </option>
  </select>
  <br>

  Data:
  <textarea name="gradeData" rows="5" cols="50" placeholder="Please enter the names and grades seperated by a comma..."></textarea>

  <br>

  <input type="submit" name="precious" value="Submit">

</form>

<div style ="background-color: black; width=10;">
  ayyyyyy
</div>

<h1>
  <?php echo $title ?>
</h1>

<?php
    display();
?>

</body>
</html>
