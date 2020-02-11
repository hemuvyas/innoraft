<?php
$array = array(
	array('pd' => 'pd1', 'sp' => 5, 'sd' => '4thFeb', 'ct' => 'C1'),
	array('pd' => 'pd1', 'sp' => 15, 'sd' => '5thFeb', 'ct' => 'C1'),
	array('pd' => 'pd2', 'sp' => 50, 'sd' => '4thFeb', 'ct' => 'C1'),
	array('pd' => 'pd3', 'sp' => 40, 'sd' => '6thFeb', 'ct' => 'C2'),
	array('pd' => 'pd2', 'sp' => 75, 'sd' => '3rdFeb', 'ct' => 'C1'),
	array('pd' => 'pd2', 'sp' => 65, 'sd' => '7thFeb', 'ct' => 'C1'),
	array('pd' => 'pd4', 'sp' => 190, 'sd' => '8thFeb', 'ct' => 'C2'),);

function compareByTimeStamp($time1, $time2) 
{ 
	if (strtotime($time1['sd']) > strtotime($time2['sd'])) 
		return 1; 
	else if (strtotime($time1['sd']) < strtotime($time2['sd']))  
		return -1; 
	else
		return 0; 
} 

function compareByPd($a, $b) {
	if ($a['pd'] == $b['pd']) return 0;
	return ($a['pd'] < $b['pd']) ? -1 : 1;
}

usort($array, 'compareByTimeStamp');
usort($array, 'compareByPd');
$tsp=array();
foreach ($array as $key => $value) {
	if ($key > 0) {
		for ($i=0; $i < $key; $i++) { 
			if ($array[$i]['pd'] == $value['pd']) {
				if (isset($tsp[$key])) {
					$tsp[$key] = $array[$i]['sp'] + $tsp[$key];
				}
				else {
					$tsp[$key] = $array[$i]['sp'] + $value['sp'];
				}
			}
		}
	}
}
foreach ($tsp as $key => $value) {
	foreach ($array as $a_key => &$a_value) {
		if ($key == $a_key) {
			$a_value['sp'] = $tsp[$key];
		}
	}
}
// Question 2
$counter = array();
foreach ($array as $key => $value) {
	if(isset($counter[$value['ct']])){
		$counter[$value['ct']] += 1;
	}
	else {
		$counter[$value['ct']]=1;
	}
}
foreach ($counter as $counter_key => $counter_value) {
	$p=1;
	for ($i=0; $i < count($array); $i++) { 
		if($counter_key==$array[$i]['ct']){
			$array[$i]['ct'] = $counter_key."-P".$p;
			$p++;
		}
	}
}
print_r($array);
?>