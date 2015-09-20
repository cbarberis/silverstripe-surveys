<?php

class SurveyQuestion extends DataObject {

	private static $db = array(
		"Number" => "Int",
		"Title" => "Varchar(255)",
		"Description" => "Varchar(255)",
		"HelpText" => "HTMLText",
		"Type" => "Varchar(255)"
	);

	private static $has_one = array(
		"Section" => "Section"
	);

	private static $has_many = array(
		"Questions" => "Question"
	);

	private static $summary_fields = array(
		"Number" => "Number",
		"Title" => "Title",
		"ListOfQuestions" => "Questions"
	);



	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Type');

		return $fields;
	}

	function ListOfQuestions() {
		$output = '';
		foreach($this->Questions() as $sq) {
			$output .= "Label: \"" . $sq->Label . "\" | Type: \"" . $sq->ClassName . "\"<br>";
		}
		$richText = new HTMLText('something');
		$richText->setValue($output);
		return $richText;
	}
}