SilverStripe Surveys
=================

Create surveys/forms that are rendered with AngularJS in the front-end. A json files is generated with the forms content in a ways that the AngularJS controller can understand. 


## Requirements
* SilverStripe 3.1.x


## Installation
* clone or download the module from here https://github.com/cbarberis/silverstripe-surveys
* Extract the downloaded archive into your site root so that the destination folder is called surveys, opening the extracted folder should contain _config.php in the root along with other files/folders
* Run dev/build?flush=all to regenerate the manifest


If you prefer you may also install using composer:
```
composer require cbarberis/silverstripe-surveys
```

## Usage
You can create surveys that have multiple sections. Each section can have multiple questions. A json file is generated with the form/survey content. AngularJS uses this file to render the survey in the front-end. 
There are multiple types of fields (text, dropdown, etc). Each field type has an Angularjs template and directive. 