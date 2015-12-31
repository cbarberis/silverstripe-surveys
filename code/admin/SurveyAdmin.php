<?php

class SurveyAdmin extends ModelAdmin
{

    private static $managed_models = array(
        'Survey',
        'SurveyQuestion',
        'Question',
        'Section'
    );

    private static $url_segment = 'forms';

    private static $menu_title = 'Manage Forms';

    private static $menu_icon = 'framework/admin/images/menu-icons/16x16/pencil.png';

    public function init()
    {
        parent::init();
        Requirements::css(SURVEYS_DIR . '/css/SurveyAdmin.css');
        Requirements::javascript(SURVEYS_DIR . '/javascript/SurveyAdmin.js');
    }


    protected function getManagedModelTabs()
    {
        $models = array('Survey' => array('title' => 'Surveys'));
        $forms  = new ArrayList();
        
        foreach ($models as $class => $options) {
            $forms->push(new ArrayData(array(
                'Title'     => $options['title'],
                'ClassName' => $class,
                'Link' => $this->Link($this->sanitiseClassName($class)),
                'LinkOrCurrent' => ($class == $this->modelClass) ? 'current' : 'link'
            )));
        }
        
        return $forms;
    }
}
