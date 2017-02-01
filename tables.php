<?php

  function display()
  {
    if(isset($_POST['precious']))
    {
     makeTable();
    }
  }

  function makeTable()
  {
          echo '<table border="1"><tr><td><b>Name</b></td><td><b>Grade</b></td><td><b>Chart</b></td></tr>';

          $arr = explode(PHP_EOL, $_POST['gradeData']);
          foreach ($arr as $value)
          {
            $newArr = explode(',', $value);
            echo '<tr>';
            foreach ($newArr as $newVal)
            {
              echo '<td>'.$newVal.'</td>';
            }
            echo '<td>Blank</td>';
            echo '</tr>';
          }

          echo '</table>';



  }

 ?>
