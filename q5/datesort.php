<?php
/**
 * @file
 *  This file contains the solution of question 5 given by mentors.
 */

// Array is defined on the basis of question given.
$array = array(
	array('pd' => 'pd1', 'sp' => 5, 'sd' => '4thFeb', 'ct' => 'C1'),
	array('pd' => 'pd1', 'sp' => 15, 'sd' => '5thFeb', 'ct' => 'C1'),
	array('pd' => 'pd2', 'sp' => 50, 'sd' => '4thFeb', 'ct' => 'C1'),
	array('pd' => 'pd3', 'sp' => 40, 'sd' => '6thFeb', 'ct' => 'C2'),
	array('pd' => 'pd2', 'sp' => 75, 'sd' => '3rdFeb', 'ct' => 'C1'),
	array('pd' => 'pd2', 'sp' => 65, 'sd' => '7thFeb', 'ct' => 'C1'),
	array('pd' => 'pd4', 'sp' => 190, 'sd' => '8thFeb', 'ct' => 'C2'),);

/**
 * Function to sort array on the basis of time.
 * @param  array $time1 
 *  takes array as an argument which need to be sorted.
 * @param  array $time2 
 *  takes array as an argument which need to be sorted.
 *  
 * @return int      
 *  returns index value which is further used for sorting.
 */
function compareByTimeStamp($time1, $time2) 
{ 
	if (strtotime($time1['sd']) > strtotime($time2['sd'])) 
		return 1; 
	else if (strtotime($time1['sd']) < strtotime($time2['sd']))  
		return -1; 
	else
		return 0; 
} 

/**
 * Function to sort array on the basis of product id.
 * @param  array $a 
 *  takes array as an argument which need to be sorted.
 * @param  array $b 
 *  takes array as an argument which need to be sorted.
 * 
 * @return int      
 *  returns index value which is further used for sorting.
 */
function compareByPd($a, $b) {
	if ($a['pd'] == $b['pd']) return 0;
	return ($a['pd'] < $b['pd']) ? -1 : 1;
}

// Array is sorted on the basis of time and then product Id.
usort($array, 'compareByTimeStamp');
usort($array, 'compareByPd');

// New array is defined which is used to store the total selling price (by consecutive sum of same pid's).
$tsp=array();
foreach ($array as $key => $value) {
	
	// Checks if the element is first or not.
	if ($key > 0) {

		// Same array is looped through all its previous values.
		for ($i=0; $i < $key; $i++) { 
			
			// Same product id's are matched.
			if ($array[$i]['pd'] == $value['pd']) {
				
				// If $tsp[$key] is not set then it will set the value, else it will increment by previous value.
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

// Total selling price for same pid's are updated in main array.
foreach ($tsp as $key => $value) {
	foreach ($array as $a_key => &$a_value) {
		if ($key == $a_key) {
			$a_value['sp'] = $tsp[$key];
		}
	}
}

// Array is defined which can be used to store the different categories along with it's frequency.
$counter = array();

// Looped through array to store the different categories along with it's frequency.
foreach ($array as $key => $value) {
	if(isset($counter[$value['ct']])){
		$counter[$value['ct']] += 1;
	}
	else {
		$counter[$value['ct']]=1;
	}
}

// Looped through main array to modify the category with proper given format.
foreach ($counter as $counter_key => $counter_value) {
	
	// Modify value of category only if there are more than one products of same category.
	if ($counter_value > 1) {
		$p=1;
		for ($i=0; $i < count($array); $i++) { 
			if($counter_key==$array[$i]['ct']){
				$array[$i]['ct'] = $counter_key."-P".$p;
				$p++;
			}
		}
	}
}

// Final array is printed.
print_r($array);
?>