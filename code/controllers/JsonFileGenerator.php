<?php

class JsonFileGenerator extends Controller {

	function index() {
		$posts = $this->request->postVars();
		$filename = $posts['filename'];
		$surveyID = intval($posts['surveyID']);

		if(!$filename || !Member::currentUser() || !$surveyID || !$Survey = Survey::get()->filter('ID', $surveyID)->first()) {
			return false;
		}

		$folder = Folder::find_or_make('jsonFormFiles');
		$fullFileName = Director::baseFolder() . '/' . $folder->getRelativePath() . $filename . '.json';

		$jsonString = '{"name":"'.$Survey->Name.'","startDate": "'.$Survey->StartDate.'", "endDate": "'.$Survey->EndDate.'","sections": [';
		foreach($Survey->Sections() as $Section) {
			$jsonString .= '{"Title": "'.$Section->Title.'","Descripton": "'.$Section->Description.'","sectionQuestions": [';
			foreach($Section->SurveyQuestions() as $SQ) {
				$jsonString .= '{"number": "'.$SQ->Number.'","title": "'.$SQ->Title.'","description":"'.$SQ->Description.'","helpText": "'.$SQ->HelpText.'","questions": [';
				foreach($SQ->Questions() as $Question) {
					$jsonString .= $Question->renderJson();
				}
				$jsonString = substr($jsonString, 0, -1);
				$jsonString .= ']},';
			}
			$jsonString = substr($jsonString, 0, -1);
			$jsonString .= ']},';
		}
		$jsonString = substr($jsonString, 0, -1);
		$jsonString .= ']}';

		file_put_contents($fullFileName, $jsonString);

		$Survey->LastJsonGenerated = SS_Datetime::now()->getValue();
		$Survey->write();
	}
}
