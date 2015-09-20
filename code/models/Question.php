<?php

class Question extends DataObject {

	private static $db = array(
		"Label" => "Varchar(255)",
		"Mandatory" => "Boolean",
		"HelpText" => "Varchar(255)"
	);

	private static $has_one = array(
		"SurveyQuestion" => "SurveyQuestion"
	);

	private static $summary_fields = array(
		"Label", "ClassName"
	);

	public static function get_question_types() {
		$classes = array();
		foreach(ClassInfo::subclassesFor('Question') as $i => $class){
			if($class != 'Question' && !ClassInfo::classImplements($class, 'TestOnly')) $classes[$class] = $class;
		}
		return $classes;
	}

	function getQuestionFields() {
		$fs = new FormScaffolder($this);
		$fs->includeRelations = false;
		$fs->restrictFields = false;
		$questionFields = array();
		$fields = $fs->getFieldList()->items;

		if($fields) foreach($fields as $field) {
			if($field->Name == 'Type' || $field->Name == 'SurveyQuestionID') continue;
			$field->setName($field->Name . "-for-" . $this->ClassName);
			$questionFields[] = $field;
		}
		
		return $questionFields;
	}

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$classes = self::get_question_types();
		if(!$this->ID) {

			$fields->removeByName('SurveyQuestionID');
			$fields->removeByName('Label');
			$fields->removeByName('Mandatory');
			$fields->removeByName('HelpText');
			$fields->addFieldToTab('Root.Main', DropdownField::create('Type', 'Choose a type for this question', $classes)->setEmptyString('Select a question type...'));

			foreach($classes as $class) {
				$tmpClass = $class::create();
				$tmpClassFields = $tmpClass->getQuestionFields();

				$fields->addFieldToTab('Root.Main', new LiteralField('SpecificFields-start-' . $class, '<div class="specific-fields ' . $class . ' hidden">'));

				foreach($tmpClassFields as $field) {
					$fields->addFieldToTab('Root.Main', $field);
				}
				$fields->addFieldToTab('Root.Main', new LiteralField('SpecificFields-end-' . $class, '</div>'));
			}
		} else {
			$fields->addFieldToTab('Root.Main', new ReadonlyField('ClassNameField', 'Type', $this->ClassName), 'Label');
		}

		return $fields;
	}

	function onBeforeWrite() {
		parent::onBeforeWrite();
		if(!$this->isInDb()) {
			if($this->Type) {
				$this->ClassName = $this->Type;
			}

			foreach(DataObject::database_fields($this->ClassName) as $fieldName => $fieldType) {
				$this->$fieldName = $this->record[$fieldName . "-for-" . $this->ClassName];
			}
			$this->Label = $this->record["Label-for-" . $this->ClassName];
		}
	}

	function renderJson() {

		$str = $this->jsonSchema;
		eval("\$str = \"$str\";");
		return str_replace("'", '"', $str) . ',';
	}


}
