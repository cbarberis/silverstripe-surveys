<?php

class Survey extends DataObject
{

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

    private static $singular_name = 'Form';
    
    private static $plural_name = 'Forms';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('LastJsonGenerated');
        if ($this->ID) {
            if (!$jsonFileName = $this->JsonFileName) {
                $filter = URLSegmentFilter::create();
                $jsonFileName = $filter->filter($this->Name);
            }

            $fields->addFieldToTab("Root.Main", new LiteralField('GenerateJsonFileButton', '<button class="json-generation" data-survey-id="'.$this->ID.'" data-survey-filename="'.$jsonFileName.'">Generate JSON file</button>'));
        }

        $fields->addFieldToTab('Root.Main', new ReadonlyField('LastJsonGeneratedRO', 'Json last generated', $this->LastJsonGenerated), 'GenerateJsonFileButton');

        return $fields;
    }

    protected function onbeforeWrite()
    {
        parent::onBeforeWrite();

        $filter = URLSegmentFilter::create();
        $this->JsonFileName = $filter->filter($this->Name);
    }


    public function getJsonFile()
    {
        $folder = Folder::find_or_make('jsonFormFiles');
        $filePath = Director::baseFolder() . '/' . $folder->getRelativePath() . $this->JsonFileName . '.json';
        return file_get_contents($filePath);
    }
}
