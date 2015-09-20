<?php

class Section extends DataObject {
	
	private static $db = array(
		"Title" => "Varchar(255)",
		"Description" => "HTMLText"
	);

	private static $has_one = array(
		"Survey" => "Survey"
	);

	private static $has_many = array(
		"SurveyQuestions" => "SurveyQuestion"
	);

	private static $summary_fields = array(
		"Title" => "Title",
		"NumberOfQuestions" => "Number of Questions",
		"ListOfQuestions" => "Questions in this section"
	);

	function NumberOfQuestions() {
		return $this->SurveyQuestions()->count();
	}

	function ListOfQuestions() {
		$output = '';
		foreach($this->SurveyQuestions() as $sq) {
			$output .= $sq->Number . " " . $sq->Title . "<br>";
		}
		$richText = new HTMLText('something');
		$richText->setValue($output);
		return $richText;
	}
}