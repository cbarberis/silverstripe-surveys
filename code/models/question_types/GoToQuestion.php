<?php

class GoToQuestion extends Question {

	private static $db = array(
		"QuestionToGoNumber1" => "Int",
		"QuestionToGoNumber2" => "Int"

	);

	private static $has_one = array();

	public $jsonSchema = '{
		\'label\': \'$this->Label\',
		\'mandatory\': $this->Mandatory,
		\'type\': \'$this->ClassName\',
		\'routes\': [\'$this->QuestionToGoNumber1\', \'$this->QuestionToGoNumber2\']
	}';

}