<?php

/**
*
* @file first.php
*  Solution of first question given on 6th feb.
*/

// Array is defined which contains details of student.
$student = array(
	0 => array(
		'id' => 'st1', 
		'name' => 'Hemant', 
		'dob' => strtotime("1990-02-01"), 
		'grade' => '12'
	),
	1 => array(
		'id' => 'st2', 
		'name' => 'Yash',
		'dob' => strtotime("1998-08-14"), 
		'grade' => '11' 
	),
	2 => array(
		'id' => 'st3', 
		'name' => 'Zubin', 
		'dob' => strtotime("1994-08-11"), 
		'grade' => '11' 
	)
);

// Array is defined for subjects for specific grades with subject code and minimum marks.
$subject = array(
	0 => array(
		'grade' => 12, 
		'name' => 'math', 
		'code' => '12M', 
		'mm' => 60
	),
	1 => array(
		'grade' => 12, 
		'name' => 'eng', 
		'code' => '12E', 
		'mm' => 80
	),
	2 => array(
		'grade' => 12, 
		'name' => 'hindi', 
		'code' => '12H', 
		'mm' => 60
	),
	3 => array(
		'grade' => 11, 
		'name' => 'math', 
		'code' => '11M', 
		'mm' => 55
	),
	4 => array(
		'grade' => 11, 
		'name' => 'eng', 
		'code' => '11E', 
		'mm' => 60
	),
	5 => array(
		'grade' => 11, 
		'name' => 'hindi', 
		'code' => '11H', 
		'mm' => 70
	)
);

/** This function is used to display subjects of grade.
* @param int $grade
*  Grade of student in which he is studying.
* @param array $subs
*  This array contains the subjects for each grade.
*/
function subjects_of_grade ($grade, $subs) {
	foreach ($subs as $subject) {
		if($subject['grade'] == $grade){
			echo "<br>";
			echo "Subject code".$subject['code']."-> Subject name :".$subject['name'];
		}
	}
}

// Calling the function to display the subject for grade.
subjects_of_grade (12, $subject);

// Data Structure for obtained marks of students.
$obtainedMarks = array (
	'st1' => array (
		'math' => '100', 
		'eng' => '00', 
		'hindi' => '70'
	),
	'st2' => array (
		'math' => '80', 
		'eng' => '70', 
		'hindi' => '62'
	),
	'st3' => array (
		'math' => '80', 
		'eng' => '40', 
		'hindi' => '36'
	)
);

/**This function is used to display marks of students on the basis of their id.
* @param int $sid
*  Id of particular student.
* @param array $obtainedMarks
*  array which contains marks obtained by students.
*/

function marks_of_student ($sid, $obtainedMarks) {
	foreach ($obtainedMarks as $key => $marks) {
		if($key == $sid){
			echo "<br><br>Marks of ".$sid." is:<br>";
			foreach ($marks as $sub => $mark) {
				echo $sub." ".$mark." &nbsp; ";
			}
		}
	}
}

// Function is called to display marks obtained by 'st1'.
marks_of_student('st1', $obtainedMarks);

/** This function calculates the result for students, whether they are pass or not on the basis of marks scored in the exam.
* @param int $sid
*  Id of particular student.
* @param array $student
*  This array contains the data of students with their details.
* @param array $subs
*  This array contains details of the subjects along with their min. passing marks.
* @param array $obtainedMarks
*  This array contains details about marks obtained by students.
* @return string 
*  If student is passed then return pass else return fail. 
*/
function  result ($sid, $student, $subs, $obtainedMarks) {
	$pass = 0; $fail = 0;
	foreach ($student as $id => $details) {
		if ($details['id'] == $sid) {
			foreach ($obtainedMarks as $oid => $omarks) {
				if ($oid == $sid) {
					foreach ($subs as $msubs) {
						if ($details['grade'] == $msubs['grade']) {
							if ($msubs['name'] == 'hindi' && $omarks['hindi'] > $msubs['mm']) {
								$pass++;
							}
							elseif ($msubs['name'] == 'eng' && $omarks['eng'] > $msubs['mm']) {
								$pass++;
							}
							elseif ($msubs['name'] == 'math' && $omarks['math'] > $msubs['mm']) {
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
	$total = $pass + $fail ;
	if ($pass/$total >= 0.4) {
		return "Pass";
	}
	else {
		return "fail";
	}
}

// Driver Code which displays the results of student in specified table format.
echo "<table border=1 style='width:70%; border-collapse: collapse;'><th>Name</th><th>DOB</th><th>Marks</th><th>Grade</th><th>Result</th>";
foreach ($student as $key => $value) {
	echo "<tr><td>".$value['name']."</td><td>".date("Y-m-d", ($value['dob']))."</td>";
	foreach ($obtainedMarks as $id => $sub) {
		foreach ($subject as $msubs) {
			if ($value['id']==$id && $value['grade']==$msubs['grade']) {
				if ($msubs['name']== 'math') {
					echo "<td>".$msubs['code']."(".$sub['math'].",".$msubs['mm'].")<br>";
				}
				if ($msubs['name']== 'eng') {
					echo $msubs['code']."(".$sub['eng'].",".$msubs['mm'].")<br>";
				}
				if ($msubs['name']== 'hindi') {
					echo $msubs['code']."(".$sub['hindi'].",".$msubs['mm'].")</td>";
				}
			}
		}
	}
	echo  "<td>".$value['grade']."</td><td>".result($value['id'],$student,$subject,$obtainedMarks)."</td></tr>";
}

?>
