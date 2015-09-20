<?php

class Survey extends DataObject {

	private static $db = array(
		"Name" => "Varchar(255)",
		"Description" => "HTMLText",
		"URLSegment" => "Varchar(255)",
		"StartDate" => "Date",
		"EndDate" => "Date",
		"State" => "Enum('Draft,Live','Draft')",
		"SubmissionMessage" => "HTMLText",
		"SubmissionURL" => "Varchar(255)",
		'LastJsonGenerated' => 'SS_Datetime',
		'JsonFileName' => 'Varchar(255)'
	);

	private static $has_one = array();

	private static $has_many = array(
		"Sections" => "Section"
	);

	private static $summary_fields = array(
		'Name' => 'Form name',
		'LastJsonGenerated' => 'Last time Json was generated',
		'JsonFileName' => 'Json file name'
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('LastJsonGenerated');
		if($this->ID) {
			
			if(!$jsonFileName = $this->JsonFileName) {
				$filter = URLSegmentFilter::create();
				$jsonFileName = $filter->filter($this->Name);
			}

			$fields->addFieldToTab("Root.Main", new LiteralField('GenerateJsonFileButton', '<button class="json-generation" data-survey-id="'.$this->ID.'" data-survey-filename="'.$jsonFileName.'">Generate JSON file</button>'));	
		}

		$fields->addFieldToTab('Root.Main', new ReadonlyField('LastJsonGeneratedRO', 'Json last generated', $this->LastJsonGenerated), 'GenerateJsonFileButton');

		return $fields;
	}
}