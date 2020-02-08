<?php
/**
* @file
*  This file contains the solution of 4th question with OOPS given on 6th feb. 
*/

// Globally array is defined.
$array=array();

// Class for data that we require is defined.
class data{
	public $name;
	public $gender;
}

// Array is hardcoded with all the entries.
$array[0] = new data();
$array[0]->name = 'Hemant';
$array[0]->gender = 'M';
$array[1] = new data();
$array[1]->name = 'Zubin';
$array[1]->gender = 'M';
$array[2] = new data();
$array[2]->name = 'Yash';
$array[2]->gender = 'M';
$array[3] = new data();
$array[3]->name = 'man';
$array[3]->gender = 'M';
$array[4] = new data();
$array[4]->name = 'Bradd pitt';
$array[4]->gender = 'M';
$array[5] = new data();
$array[5]->name = 'Tom';
$array[5]->gender = 'M';
$array[6] = new data();
$array[6]->name = 'Jiyan';
$array[6]->gender = 'M';
$array[7] = new data();
$array[7]->name = 'Shizuka';
$array[7]->gender = 'F';
$array[8] = new data();
$array[8]->name = 'Dorame';
$array[8]->gender = 'F';
$array[9] = new data();
$array[9]->name = 'Selena';
$array[9]->gender = 'F';

// A new class is defined where we do all logical operations.
class work {
	public $boy = array();
	public $girl = array();
	public $final = array();
	public $counter;

	/**
	 * Function to seperate both boys and girls and then joined consecutively.
	 * 
	 * @param  array $array 
	 *  array of boys and girls are passed.
	 * 
	 * @return mixed
	 *  Only set the values of class with appropriate logic operations.
	 */
	function seperate($array) {
		for ($i=0; $i < count($array); $i++) {
			if ($array[$i]->gender == 'F') {
				array_push($this->girl, $array[$i]);
			}
			else {
				array_push($this->boy, $array[$i]);
			}
		}
		$this->counter = count($this->girl);
		$i = 0;
		while ($i < 2*$this->counter) {
			$this->final[$i]=array_shift($this->girl);
			$this->final[$i+1]=array_shift($this->boy);
			$i += 2;
		}
		$this->final = array_merge($this->final, $this->boy);
	}

	/**
	 * Displays the output only with their names.
	 * 
	 * @return mixed 
	 *  Display the names.
	 */
	function display() {
		for ($i=0; $i < count($this->final); $i++) { 
			echo "".$this->final[$i]->name."<br>";
		}
	}
}

// Object of work class is declared and its methods are called.
$output = new work();
$output->seperate($array);
$output->display();

?>