<!----------funtion display(), shows the table to the screen ---------->
<!---------- function maketable(), uses information gathered in the text area to make the actual table that is then shown to the screen.------->
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
  	  $highestScore = 0;
	  $highestName  = "";
	  $lowestScore  = -1;
	  $lowestName   = "";
	  $averageScore = 0;
	  $averageCount = 0;
	  $averageSum   = 0;
	  $gradeData = array();
	  $sortType  = $_POST['sortType'];	//Get the Sort selection
	  $chartType = $_POST['chartType'];	//Get the Chart selection

	  //Split the gradeData into an array by EOL
          $arr = explode(PHP_EOL, $_POST['gradeData']);
	  //Loop through and append values as ["name"]=score
          foreach ($arr as $value){
            $newArr = explode(',', $value);
	    $newArr[1] = (int)$newArr[1];//Convert to int
	    if($newArr[0]!=""){
	      $gradeData += array($newArr[0] => $newArr[1]);
	      //Checking Scores
	      if($newArr[1]>$highestScore){
	        $highestName  = $newArr[0];
	        $highestScore = $newArr[1];
	      }
	      if(($newArr[1]<$lowestScore) || $lowestScore==-1){
	        $lowestName  = $newArr[0];
	        $lowestScore = $newArr[1];
	      }
	      $averageSum += $newArr[1];
	      $averageCount++;
            }
	  }

	  //Sorting
	  if($sortType=="Name"){
	    ksort($gradeData);
          }
	  if($sortType=="Score"){
	    arsort($gradeData);
	  }
	  if($sortType=="Last Name"){
	    lastNameSort($gradeData);
	  }

	  //Heading
	  $averageScore = round($averageSum/$averageCount,2);
	  echo 'Highest Score: '.$highestScore.' by '.$highestName.'<br>';
	  echo 'Lowest Score: '.$lowestScore.' by '.$lowestName.'<br>';
	  echo 'Average Score: '.$averageScore.'<br>';
    echo 'Chart Type: '.$chartType.'<br>';
    echo 'Sorted By: '.$sortType.'<br>';
    echo '<br>';


	  //Spit out the final table
	  echo '<table border="1"><tr><td><b>Name</b></td><td><b>Grade</b></td><td><b>Chart</b></td></tr>';
	  foreach ($gradeData as $name => $grade){
	    //Chart
	    if(charType=="None"){
		  $charOutput = '<h2>BLANK</h2>';
	    }
	    if($chartType=="Asterisk"){
		  $charOutput = str_repeat('*',($grade - ($grade % 10))/10 );//Is there really no DIV in php?
	    }
            echo '<tr>';
	    echo '<td>'.$name.'</td>';
	    echo '<td>'.$grade.'</td>';
	    echo '<td>'.$charOutput.'</td>';//Is there really no DIV in php?
            echo '</tr>';
	  }


          echo '</table>';



  }

  function lastNameSort(& $gradeData){
    //I'm sure there is a better way
    foreach ($gradeData as $origName => $origGrade){
      $nameArr = explode(' ',$origName);
      unset($gradeData[$origName]);
      $gradeData += array(($nameArr[1].' '.$nameArr[0]) => $origGrade);
    }

    //Now sort alphabetically by last name
    ksort($gradeData);
    foreach ($gradeData as $postName => $postGrade){
      $nameArr = explode(' ',$postName);
      unset($gradeData[$postName]);
      $gradeData += array(($nameArr[1].' '.$nameArr[0]) => $postGrade);
    }
  }



 ?>
