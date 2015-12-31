<?php

class MultipleOptionsQuestion extends Question
{

    private static $db = array(
        "IsOtherOption" => "Boolean",
        "IsOtherAnswer" => "Text"
    );

    private static $has_one = array();

    public $jsonSchema = '{
		\'label\': \'$this->Label\',
		\'mandatory\': $this->Mandatory,
		\'type\': \'$this->ClassName\'
	}';
}
