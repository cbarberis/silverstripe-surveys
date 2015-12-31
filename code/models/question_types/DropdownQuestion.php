<?php

class DropdownQuestion extends Question
{

    private static $db = array(
        "OptionsType" => "Enum('UserDefined,Month,Year','UserDefined')",
        "Options" => "Text"
    );

    private static $has_one = array();

    public $jsonSchema = '{
		\'label\': \'$this->Label\',
		\'mandatory\': $this->Mandatory,
		\'type\': \'$this->ClassName\',
		\'options\': $this->DropdownOptions
	}';

    public function getDropdownOptions()
    {
        $options = explode(',', $this->Options);
        $string = '[';
        foreach ($options as $opt) {
            $string .= '{\'label\':\''.$opt.'\', \'value\':\''.$opt.'\'},';
        }

        $string = substr($string, 0, -1);
        return $string .= ']';
    }
}
