<?php

$sarray = array(
	0 => array(
		'id' => 'st1', 
		'name' => 'Hemant', 
		'dob' => strtotime("1990-02-01"), 
		'grade' => '12',
	),
	1 => array(
		'id' => 'st2', 
		'name' => 'Yash',
		'dob' => strtotime("1998-08-14"), 
		'grade' => '11',
	),
	2 => array(
		'id' => 'st3', 
		'name' => 'Zubin', 
		'dob' => strtotime("1994-08-11"), 
		'grade' => '11', 
	),
);
$student = json_decode(json_encode($sarray));

$subject_array = array(
	0 => array(
		'grade' => 12, 
		'name' => 'math', 
		'code' => '12M', 
		'mm' => 60,
	),
	1 => array(
		'grade' => 12, 
		'name' => 'eng', 
		'code' => '12E', 
		'mm' => 80,
	),
	2 => array(
		'grade' => 12, 
		'name' => 'hindi', 
		'code' => '12H', 
		'mm' => 60,
	),
	3 => array(
		'grade' => 11, 
		'name' => 'math', 
		'code' => '11M', 
		'mm' => 55,
	),
	4 => array(
		'grade' => 11, 
		'name' => 'eng', 
		'code' => '11E', 
		'mm' => 60,
	),
	5 => array(
		'grade' => 11, 
		'name' => 'hindi', 
		'code' => '11H', 
		'mm' => 70,
	),
);
$subject = json_decode(json_encode($subject_array));

$marks_array = array (
	'st1' => array (
		'math' => '100', 
		'eng' => '00', 
		'hindi' => '70',
	),
	'st2' => array (
		'math' => '80', 
		'eng' => '70', 
		'hindi' => '62',
	),
	'st3' => array (
		'math' => '80', 
		'eng' => '40', 
		'hindi' => '36',
	),
);
$marks = json_decode(json_encode($marks_array));

/**
 * Inside this class display functions are defined.
 */
class display
{
	/** This function is used to display subjects of grade.
	*
	* @param int $grade
	*  Grade of student in which he is studying.
	* @param array $subs
	*  This array contains the subjects for each grade.
	* 
	* @return mixed
	*  It displays the grade.
	*/
	function subjects_of_grade($grade, $subject) {
		
		// Loops through array of subjects, so we can use them.
		foreach ($subject as $subjects) {

			// Checks if the grade of student and grade passed in parameter are same or not.
			if ($subjects->grade == $grade) {
				echo "<br>";
				echo "Subject code ".$subjects->code." -> Subject name : ".$subjects->name;
			}
		}
	}

	/**This function is used to display marks of students on the basis of their id.
	*
	* @param int $id
	*  Id of particular student.
	* @param array $Marks
	*  Array which contains marks obtained by students.
	* 
	* @return mixed
	*  It display the marks of student.
	*/
	function marks_of_student($id, $Marks) {

		// Loops through the marks obtained by the students.
		foreach ($Marks as $key => $marks) {

			// Matches the student Id with with passed parameter.
			if($key == $id){
				echo "<br><br>Marks of ".$id." is:<br>";

				// Loops through marks to display marks.
				foreach ($marks as $sub => $mark) {
					echo $sub." ".$mark." &nbsp; ";
				}
			}
		}
	}
}

// New object of display class is defined so that we can call its method to display the subjects in a grade and also marks of the students.
$op=new display();
$op->subjects_of_grade(12, $subject);
$op->marks_of_student('st1', $marks);

class calculations
{
	function  result($id, $student, $subs, $Marks) {

		// Initialised $pass and $fail with 0 at start of every counter of loop.
		$pass = 0; $fail = 0;

		// Loops through the students with specific id and their details(array).
		foreach ($student as $id1 => $details) {

			// Matches the id of each student with passed student id.
			if ($details->id == $id) {

				// Loops through obtained marks of the students.
				foreach ($Marks as $oid => $omarks) {

					// Matches the id of each student with passed student id.
					if ($oid == $id) {

						// Loops through array of subjects.
						foreach ($subs as $msubs) {

							// Checks if their grades match or not.
							if ($details->grade == $msubs->grade) {

								// Checks for specified subject and if they are passed then $pass is incremented by 1 else $fail is incrmented by 1.
								if ($msubs->name == 'hindi' && $omarks->hindi > $msubs->mm) {
									$pass++;
								}
								elseif ($msubs->name == 'eng' && $omarks->eng > $msubs->mm) {
									$pass++;
								}
								elseif ($msubs->name == 'math' && $omarks->math > $msubs->mm) {
									$pass++;
								}
								else {
									$fail++;
								}
							}
						}
					}
				}
			}
		}

		// Calculates whether the students are passed or not on the basis of their marks in each subject.
		$total = $pass + $fail ;
		if ($pass/$total >= 0.4) {
			return "Pass";
		}
		else {
			return "Fail";
		}
	}
}

$calc = new calculations();
echo "<table border=1 style='width:70%; border-collapse: collapse;'><th>Name</th><th>DOB</th><th>Marks</th><th>Grade</th><th>Result</th>";
foreach ($student as $key => $value) {
	echo "<tr><td>".$value->name."</td><td>".date("Y-m-d", ($value->dob))."</td>";
	
	// Loops through marks obtained by the students.
	foreach ($marks as $id => $sub) {
		
		// Loops through every subject.
		foreach ($subject as $msubs) {
			
			// Matches for id of students and their grades.
			if ($value->id==$id && $value->grade==$msubs->grade) {
				
				// Checks for subject is equal to maths.
				if ($msubs->name== 'math') {
					echo "<td>".$msubs->code."(".$sub->math.",".$msubs->mm.")<br>";
				}
				
				// Checks for subject is equal to english.
				if ($msubs->name== 'eng') {
					echo $msubs->code."(".$sub->eng.",".$msubs->mm.")<br>";
				}
				
				// Checks for subject is equal to hindi.
				if ($msubs->name== 'hindi') {
					echo $msubs->code."(".$sub->hindi.",".$msubs->mm.")</td>";
				}
			}
		}
	}

	// Grade of the student and their result is displayed by means of result function defined in calculations class.
	echo  "<td>".$value->grade."</td><td>".$calc->result($value->id,$student,$subject,$marks)."</td></tr>";
}
?>