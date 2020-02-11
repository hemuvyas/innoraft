
<!-- There is a cricket tournament between 4 teams. Each team plays one match with each other team. Now in input an array of the match will be provided in this manner. $matchA=> array('team1_name' => array('player1_name' => runs_scored, 'player2_name'......), 'team2_name' =>...............);
Now calculate the following information from the above data.
A. Highest scorer player.
B. Tournament winner team.
C. Maximum score in a match.
 -->


<?php
/**
 * @file(cricket.php)
 *  It contains the solution of question 4 on 6th feb.
 */

// Array is defined for the matches between different teams.
$match=array(
	0 => array(
		'team1' => array(
			'a1' => 23,
			'a2' => 33,
			'a3' => 43,
			'a4' => 53,
			'a5' => 56,
		),
		'team2' => array(
			'b1' => 27,
			'b2' => 44,
			'b3' => 12,
			'b4' => 78,
			'b5' => 9,
		),
	),
	1 => array(
		'team1' => array(
			'a1' => 12,
			'a2' => 35,
			'a3' => 56,
			'a4' => 5,
			'a5' => 66,
		),
		'team3' => array(
			'c1' => 85,
			'c2' => 12,
			'c3' => 11,
			'c4' => 31,
			'c5' => 16,
		),
	),
	2 => array(
		'team1' => array(
			'a1' => 24,
			'a2' => 34,
			'a3' => 44,
			'a4' => 54,
			'a5' => 55,
		),
		'team4' => array(
			'd1' => 22,
			'd2' => 46,
			'd3' => 6,
			'd4' => 18,
			'd5' => 51,
		),
	),
	3 => array(
		'team2' => array(
			'b1' => 25,
			'b2' => 16,
			'b3' => 11,
			'b4' => 53,
			'b5' => 22,
		),
		'team3' => array(
			'c1' => 75,
			'c2' => 12,
			'c3' => 5,
			'c4' => 28,
			'c5' => 19,
		),
	),
	4 => array(
		'team2' => array(
			'b1' => 27,
			'b2' => 37,
			'b3' => 23,
			'b4' => 36,
			'b5' => 42,
		),
		'team4' => array(
			'd1' => 27,
			'd2' => 44,
			'd3' => 11,
			'd4' => 45,
			'd5' => 13,
		),
	),
	5 => array(
		'team3' => array(
			'c1' => 45,
			'c2' => 50,
			'c3' => 14,
			'c4' => 5,
			'c5' => 16,
		),
		'team4' => array(
			'd1' => 27,
			'd2' => 25,
			'd3' => 14,
			'd4' => 28,
			'd5' => 50,
		),
	),
);

// Two arrays are defined for the purpose of storing team total and total score of every individual.
$team_total=array();
$individual=array();

// Three foreach loops are running so that we can go through every team, player and runs scored and use appropriate logics to calculate team total and individual toatl.
foreach ($match as $match_no => $value) {
	foreach ($value as $team => $value1) {

		// Team total is being calculated by array reduce with a callback function sum which calculated the team total in a match
		$team_total[$match_no][$team]=array_reduce($value1, 'sum');
		foreach ($value1 as $player => $run) {
			
			// If $individual[$player] is set then we will increment it by the scored runs of that player, else for the first time run is stored.
			if(isset($individual[$player])){
				$individual[$player] += $run;
			}
			else{
				$individual[$player]=$run;
			}
		}
	}
}

/**
 * A callback function which is used to total the array passed in it.
 * 
 * @param int $a
 *  First value of array passed.
 * @param int $b
 *  Second value of array passed.
 *  
 * @return int    
 *  Sum of both the integers.
 */
function sum($a, $b){
	return $a + $b;
}

// It search for the key (player) who scored maximum runs along with his run.
echo array_search(max($individual), $individual);
echo " Scored highest runs ";
echo max($individual);
echo "<br>";

// Arrays are globally defined.
$match_winner=array();
$total_innings_run=array();

// Winner are decided on the basis of who scored maximum runs in an innings.
foreach ($team_total as $match_no => $value) {
	
	// Maximum run scorer is calculated.
	$match_winner[$match_no]=array_search(max($value), $team_total[$match_no]);
	
	// Total innings runs are calculated with the call back function sum. 
	$total_innings_run[$match_no]=array_reduce($value, 'sum');
}

// Array is used to store the no. of times a team wins and tournament winner is displayed.
$score_tally=array_count_values($match_winner);
echo "Tournament winner is ";
echo array_search(max($score_tally), $score_tally);
echo "<br>";

// Highest runs scored in an innings is displayed from total_innnings_run array.
echo "Maximum is scored in Match ";
echo (array_search(max($total_innings_run), $total_innings_run)+1);
?>