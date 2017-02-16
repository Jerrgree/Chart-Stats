<!----------funtion display(), shows the table to the screen ---------->
<!---------- function maketable(), uses information gathered in the text area to make the actual table that is then shown to the screen.------->
<?php
  ini_set('auto_detect_line_endings',TRUE);
  function display()
  {
    if(isset($_POST['precious']))
    {
      if ($_FILES['csvfile']['error'] == 0)
      {
        $userfile = $_FILES['csvfile']['tmp_name'];
        $_POST['gradeData'] = $_POST['gradeData']."\n".file_get_contents($userfile)."<br>";
      }
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
	  $svgWidth = 0;
	  $countGradeA = 0;
	  $countGradeB = 0;
	  $countGradeC = 0;
	  $countGradeD = 0;
	  $countGradeF = 0;
	  $countTotalGrades = 0;



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
	      $countTotalGrades++;
	      //Check what grade this is, increment grade counter
	      if($newArr[1]>=90){
		$countGradeA++;
	      }
	      else if($newArr[1]>=80){
		$countGradeB++;
	      }
	      else if($newArr[1]>=70){
		$countGradeC++;
	      }
	      else if($newArr[1]>=60){
		$countGradeD++;
	      }
	      else{
		$countGradeF++;
	      }
	      $averageSum += $newArr[1];
	      $averageCount++;
            }
	  }

	  //Sorting
	  if($sortType=="First Name"){
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

	  //It's here so it doesn't get place in a table
	 if($chartType=="SVG-Pie"){
	   $currentCirclePos = $countGradeA;
	   $gradeAX = getPieX($currentCirclePos/$countTotalGrades);
	   $gradeAY = getPieY($currentCirclePos/$countTotalGrades);
	   $currentCirclePos += $countGradeB;
	   $gradeBX = getPieX($currentCirclePos/$countTotalGrades);
	   $gradeBY = getPieY($currentCirclePos/$countTotalGrades);
	   $currentCirclePos += $countGradeC;
	   $gradeCX = getPieX($currentCirclePos/$countTotalGrades);
	   $gradeCY = getPieY($currentCirclePos/$countTotalGrades);
	   $currentCirclePos += $countGradeD;
	   $gradeDX = getPieX($currentCirclePos/$countTotalGrades);
	   $gradeDY = getPieY($currentCirclePos/$countTotalGrades);
	   $currentCirclePos += $countGradeF;
	   $gradeFX = getPieX($currentCirclePos/$countTotalGrades);
	   $gradeFY = getPieY($currentCirclePos/$countTotalGrades);
	   //Echo the color chart
	   echo '<table style="border:1px solid black;">';
	   echo '<tr><td style="border:1px solid black;">A\'s: '.$countGradeA.'</td>';
	   echo '<td style="border:1px solid black;">B\'s: '.$countGradeB.'</td>';
	   echo '<td style="border:1px solid black;">C\'s: '.$countGradeC.'</td>';
	   echo '<td style="border:1px solid black;">D\'s: '.$countGradeD.'</td>';
	   echo '<td style="border:1px solid black;">F\'s: '.$countGradeF.'</td></tr>';
	   echo '<tr><td bgcolor="Blue" height="16" width="48"></td>';
           echo '<td bgcolor="Green" height="16" width="48"></td>';
           echo '<td bgcolor="Yellow" height="16" width="48"></td>';
           echo '<td bgcolor="Brown" height="16" width="48"></td>';
    	   echo '<td bgcolor="Red" height="16" width="48"></td></tr></table>';
	   echo '<br>';
	   //Create the Pie Chart
	   echo '<svg width="240" height="240" viewBox="-1 -1 2 2" style="transform: rotate(-90deg)">';
	   $pieArc = (($countGradeA/$countTotalGrades) > 0.50 ? 1 : 0);
	   echo '<path d="M 1 0 A 1 1 0 '.$pieArc.' 1 '.$gradeAX.' '.$gradeAY.' L 0 0" fill="Blue"></path>';
	   $pieArc = (($countGradeB/$countTotalGrades) > 0.50 ? 1 : 0);
	   echo '<path d="M '.$gradeAX.' '.$gradeAY.' A 1 1 0 '.$pieArc.' 1 '.$gradeBX.' '.$gradeBY.' L 0 0" fill="Green"></path>';
	   $pieArc = (($countGradeC/$countTotalGrades) > 0.50 ? 1 : 0);
	   echo '<path d="M '.$gradeBX.' '.$gradeBY.' A 1 1 0 '.$pieArc.' 1 '.$gradeCX.' '.$gradeCY.' L 0 0" fill="Yellow"></path>';
	   $pieArc = (($countGradeD/$countTotalGrades) > 0.50 ? 1 : 0);
	   echo '<path d="M '.$gradeCX.' '.$gradeCY.' A 1 1 0 '.$pieArc.' 1 '.$gradeDX.' '.$gradeDY.' L 0 0" fill="Brown"></path>';
	   $pieArc = (($countGradeF/$countTotalGrades) > 0.50 ? 1 : 0);
	   echo '<path d="M '.$gradeDX.' '.$gradeDY.' A 1 1 0 '.$pieArc.' 1 '.$gradeFX.' '.$gradeFY.' L 0 0" fill="Red"></path>';
	   echo '</svg>';
	 }
	 //Spit out the final table
	  echo '<table class="table table-hover table-bordered"><thead class="thead-inverse"><tr><th>Name</th><th>Grade</th><th>Chart</th></tr></thead><tbody>';
	  foreach ($gradeData as $name => $grade){
	    //Chart
	 //   if(charType=="None"){
	 //		$charOutput = '<h2>BLANK</h2>';
	 // }
	    if($chartType=="Asterisk"){
		  $charOutput = str_repeat('*',($grade - ($grade % 10))/10 );//Is there really no DIV in php?
	    }
	  //  if($chartType=="SVG Bar"){
	  //  	  $svgWidth = (($grade - ($grade % 10) ) /10) * 10;
	   // }
	    echo '<tr>';
	    echo '<td>'.$name.'</td>';
	    echo '<td>'.$grade.'</td>';
	    if($chartType!="SVG-Bar"){
	    	echo '<td>'.$charOutput.'</td>';
		//Is there really no DIV in php?
	    }

	    if($chartType=="SVG-Bar"){
	       echo '<td style ="width:100px; height:20px;background-color: white;overflow:visible;">';
	       echo '<svg width="100" height="20">';
	       echo '<rect width="'.$grade.'" height="20" style="fill:rgb(255,0,0);stroke-width:3;stroke:rgb(0,0,0)" />';
	       echo '</svg>';
	       echo '</td>';
            }
            echo '</tr>';
	  }

          echo '</tbody></table>';
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

  //Basic Trig functions that return the position on our PieChart for a given percent of the circle
  function getPieX($percent){
    $x = cos(2 * pi() * $percent);
    return $x;
  }
  
  function getPieY($percent){
    $y = sin(2 * pi() * $percent);
    return $y;
  }


 ?>
