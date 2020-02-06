
<!-- We have an array of array which contains the student data 
For example:-
 $student[0]['id'] = 'st1';
 $student[0]['name'] = 'John';
 $student[0]['dob'] = '1580812642';  //date is in timestamp
 $student[0]['grade'] = 12;



We have a function that takes grade as input and returns subject, subject code and minimum required marks to pass the subject.
Sample output:
Subject[‘name’] = ‘Subject Name’;
Subject[‘code’] = ‘Subject Code’;
Subject[mm] = 20; //passing marks


We have another function that takes student id and returns the subject code and their obtained marks.
Sample output:
$output = array(‘H’ => 16, ‘E’ => 30);


A student is considered pass only if he clears 40% of his subjects.
For example 
In 12 grade if we have 5 subjects then a student needs to clear 2 subjects to pass 12th grade.

Now, you have to print a student data in tabular format as shown below

Name
Dob
Grade
Subjects
Result
John
02/02/2000
12
H(12, 20)
E(13, 30)
M(11, 10)
S - Not Appeared


Pass










 -->

<?php
// Array of students is defined
$student=array(0 => array('id' => 'st1', 'name' => 'Hemant', 'dob' => strtotime("1990-02-01"), 'grade' => '12' ),
 1 => array('id' => 'st2', 'name' => 'Yash', 'dob' => strtotime("1998-08-14"), 'grade' => '11' ),
 2 => array('id' => 'st3', 'name' => 'Zubin', 'dob' => strtotime("1994-08-11"), 'grade' => '11' ));


//  Array for subject code and its details r defined
$subs=array(array('grade' => 12, 'name' => 'math', 'code' => '12M', 'mm' => 60),
  array('grade' => 12, 'name' => 'eng', 'code' => '12E', 'mm' => 80),
  array('grade' => 12, 'name' => 'hindi', 'code' => '12H', 'mm' => 60),
  array('grade' => 11, 'name' => 'math', 'code' => '11M', 'mm' => 55),
  array('grade' => 11, 'name' => 'eng', 'code' => '11E', 'mm' => 60),
  array('grade' => 11, 'name' => 'hindi', 'code' => '11H', 'mm' => 70));

// function to display subject for specific grades
function subs_of_grade ($grade,$subs)
{
  foreach ($subs as $subject) {
    if($subject['grade'] == $grade){
      echo "<br>";
      echo "Subject code".$subject['code']."-> Subject name :".$subject['name'];
    }
  }
}
      //sample output
subs_of_grade (12,$subs);




// Array for marks obtained of each student with student id as key
$obtainedMarks = array ('st1' => array ('math' => '100', 'eng' => '00', 'hindi' => '70'),
  'st2' => array ('math' => '80', 'eng' => '70', 'hindi' => '62'),
  'st3' => array ('math' => '80', 'eng' => '40', 'hindi' => '36'));

// function to display student with its marks obtained in each subject
function sub_by_student ($sid,$obtainedMarks){
  foreach ($obtainedMarks as $key => $marks) {
    if($key == $sid){
      echo "<br><br>Marks of ".$sid." is:<br>";
      foreach ($marks as $sub => $mark) {
        echo $sub." ".$mark." &nbsp; ";
      }
    }
  }
}
sub_by_student('st1',$obtainedMarks);


// Function to get the result(pass or fail) for each student on the basis of his marks
function  result ($sid,$student,$subs,$obtainedMarks)
{
  $pass = 0; $fail = 0;
  foreach ($student as $id => $details) {
    if($details['id'] == $sid){
      foreach ($obtainedMarks as $oid => $omarks) {
        if($oid == $sid) {
          foreach ($subs as $msubs) {
            if($details['grade'] == $msubs['grade']){
              if($msubs['name'] == 'hindi' && $omarks['hindi'] > $msubs['mm']){
                $pass++;
              }
              elseif($msubs['name'] == 'hindi' && $omarks['hindi'] < $msubs['mm']){
                $fail++;
              }
              if($msubs['name'] == 'eng' && $omarks['eng'] > $msubs['mm']){
                $pass++;
              }
              elseif($msubs['name'] == 'eng' && $omarks['eng'] < $msubs['mm']){
                $fail++;
              }
              if($msubs['name'] == 'math' && $omarks['math'] > $msubs['mm']){
                $pass++;
              }
              elseif($msubs['name'] == 'math' && $omarks['math'] < $msubs['mm']){
                $fail++;
              }
            }
          }
        }
      }
    }
  }
  $total= $pass + $fail ;
  if($pass/$total >= 0.4){
    return "Pass";
  }
  else{
    return "fail";
  }


}



//DRIVER CODE (display table as required)
echo "<table border=1 style='width:70%; border-collapse: collapse;'><th>Name</th><th>DOB</th><th>Marks</th><th>Grade</th><th>Result</th>";
foreach ($student as $key => $value) {
  echo "<tr><td>".$value['name']."</td><td>".date("Y-m-d", ($value['dob']))."</td>";
  foreach($obtainedMarks as $id => $sub){
    foreach($subs as $msubs){
      if($value['id']==$id && $value['grade']==$msubs['grade'] ){
        if($msubs['name']== 'math')
          echo "<td>".$msubs['code']."(".$sub['math'].",".$msubs['mm'].")<br>";
        if($msubs['name']== 'eng')
          echo $msubs['code']."(".$sub['eng'].",".$msubs['mm'].")<br>";
        if($msubs['name']== 'hindi')
          echo $msubs['code']."(".$sub['hindi'].",".$msubs['mm'].")</td>";
      }
    }
  }
  echo  "<td>".$value['grade']."</td><td>".result($value['id'],$student,$subs,$obtainedMarks)."</td></tr>";
}
?>
