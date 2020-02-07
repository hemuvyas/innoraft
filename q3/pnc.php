
<!-- There are 10 seats and 7 boys and 3 girls. Now arrange the students in an array in such a manner that no 2 girls sit together. The input array will be like this:
 $array = array(0-> array('name' => <student_name>, 'gender' => 'M/F')...........);
       Output array: $output = array('name1', 'name2'......);
 -->


<?php
$array = array(
	0 => array(
		'name' => 'hemant',
		'gender' => 'M'
	),
	1 => array(
		'name' => 'zubin',
		'gender' => 'M'
	),
	2 => array(
		'name' => 'yash',
		'gender' => 'M'
	),
	3 => array(
		'name' => 'man',
		'gender' => 'M'
	),
	4 => array(
		'name' => 'Brad',
		'gender' => 'M'
	),
	5 => array(
		'name' => 'bradd',
		'gender' => 'M'
	),
	6 => array(
		'name' => 'leonardo',
		'gender' => 'M'
	),
	7 => array(
		'name' => 'vinie',
		'gender' => 'F'
	),
	8 => array(
		'name' => 'selena',
		'gender' => 'F'
	),
	9 => array(
		'name' => 'tomi',
		'gender' => 'F'
	)
);
$boy=$girl=$final=array();
for ($i=0; $i < count($array); $i++) { 
	if ($array[$i]['gender'] == 'F') {
		array_push($girl, $array[$i]);
	}
	else {
		array_push($boy, $array[$i]);
	}
}
$counter=count($girl);
$i=0;
while ($i < 2*$counter) {
	$final[$i]=array_shift($girl);
	$final[$i+1]=array_shift($boy);
	$i += 2;
}
$output=(array_merge($final,$boy));
for ($i=0; $i < count($output); $i++) { 
	echo "".$output[$i]['name']."<br>";
}
?>