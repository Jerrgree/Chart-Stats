<!DOCTYPE html>
<html>

<body>

<p> Please enter your first and last name!! </p>

<!-------------Form, check w3, to ask for input, can include an action parameter, but none right now. using get method means shows in URL --------->
  <form method = "get">
    First name: <br>
      <input type = "text" name = "firstname">
      <br>
    Last name: <br>
      <input type = "text" name = "lastname">
      <br>
      <br>
      <input type = "submit" value = "Submit">
  </form>

  <?php include 'tables.php';?>
  <?php makeTable(); ?>
</body>
</html>
