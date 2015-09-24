<?php

class BasicTypeQuestion extends Question {

	private static $db = array(
		"ValidationType" => "Enum('Text,Number,Email,Currency,TextArea','Text')",
		"Pattern" => "Varchar",
		"Minlength" => "Varchar",
		"Maxlength" => "Varchar"
	);

	private static $has_one = array();

	public $jsonSchema = '{
		\'label\': \'$this->Label\',
		\'mandatory\': $this->Mandatory,
		\'type\': \'$this->ClassName\',
		\'fieldType\': \'$this->ValidationType\',
		\'pattern\': \'$this->Pattern\',
		\'minlength\': \'$this->Minlength\',
		\'maxlength\': \'$this->Maxlength\'
	}';

}