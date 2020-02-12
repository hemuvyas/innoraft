<?php
/**
 * @file
 *  Contains solution for ques 6 Ludo game
 */

// Output sequences for dice are taken from this json and then decoded.
$arr = json_decode(file_get_contents('http://learning.architbohra.com/ludo_json.php'));
// $arr[0]="32642623566141464461";
// $arr[1]="66355426266516654544";
// $arr[2]="45362334661452453153";
// $arr[3]="21615422351133423344";
// $arr[4]="22532465415122624141";
$y=0;
$turn_taken=array();

/**
 * Function will do necessary changes in the array blue.
 * 
 * @param  array $array  
 *  This array contains the outcomes of the dice.
 * @param  int $chance 
 *  This contains the index value for outcomes of the dice.
 */
function yogi($array, $chance){
	
	// To gloablly access the array blue and modify it.
	global $blue;
	if($array[$chance] == 1) {
		$blue[1] = $blue[1]-$array[$chance];
	}
}

/**
 * Function will do necessary changes in the array green.
 *
 *  @param  array $array  
 *  This array contains the outcomes of the dice.
 * @param  int $chance 
 *  This contains the index value for outcomes of the dice.
 *  
 * @return int
 *  Returns the flag value for the zubin, which represents whether he enters the green house or not.
 */
function zab($array, $chance){
	
	// To gloablly access the array green and modify it.
	global $green;
	$flag = 0;

	// If value on dice is required to enter the house then it will enter the house and flag is set to 1.
	for ($x=1; $x < 4; $x++) { 
		if ($green[$x] == $array[$chance]) {
			$flag = 1;
			$green[$x]=$green[$x]-$array[$chance];
		}
	}

	// If value on dice smaller then the required value then it will be reduced by that value inside green array
	if ($flag!=1) {
		for ($x=1; $x < 4; $x++){
			if ($array[$chance] < $green[$x]) {
				$green[$x]=$green[$x]-$array[$chance];
			}
		}
	}

	// If 1 is returned then zubin's turn is recursively called.
	if($flag==1){
		return 1;
	}
	else {
		return 0;
	}
}

// Driver code to loop through all the sequence of strings.
foreach ($arr as $key => $value) {
	
	// These arrays are used to count the current values of tokens of respective player.
	$blue[1]=1;
	$green=array(
		1 => 1,
		2 => 2,
		3 => 3,
	);

	// Each sequence in array is split into $turns array to manage the outcome of dice.
	$turns =str_split($value);

	// Looping through all the outputs in the sequence.
	for ($i=0; $i < count($turns); $i++) { 
		
		// Initially yogita got first turn so her function will run first.
		yogi($turns, $i);

		// After the function is executed then it will check for changes in the $blue array which tell whether she won or not.
		if(array_sum($blue) == 0) {
			echo "<br>Yogita Wins the game#".($key+1)." in ".($i+1)." turns";
			$y++;
			array_push($turn_taken, ($i+1));
			break;
		}

		// A label which is used to recursively call the zubin's turn if his token enters the house.
		again:
		if (($i+1) < count($turns)) {
			
			// Increment by one to assign new chance to next player(zubin) and his function is called.
			$i++;
			$decision=zab($turns, $i);

			// After the function is executed then it will check for changes in the $green array which tell whether he won or not.
			if(array_sum($green) == 0) {
				echo "<br>Zubin Wins the game#".($key+1)." in ".($i+1)." turns";
				array_push($turn_taken, ($i+1));
				break;
			}

			// Condition to check the flag which tells whether his token enters the house or not. 
			if($decision==1){
				goto again;
			}
		}

		// If all the chances are used in a sequence of string, then match will be drawn.
		else {
			echo "<br>Match is drawn";
		}
		
	}
}

// Probabilty of winner is being calculated.
echo "<br>Probability of Yogita winning the game is : ".round(($y/count($arr))*100)."%";

// The avg no. of turns required are calculated.
echo "<br>The average no. of turns are : ".round(array_sum($turn_taken)/count($turn_taken));
?>


