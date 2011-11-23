<?php
/**
* Copyright 2011 HubSpot, Inc.
*
*   Licensed under the Apache License, Version 2.0 (the 
* "License"); you may not use this file except in compliance 
* with the License.
*   You may obtain a copy of the License at
*
*       http://www.apache.org/licenses/LICENSE-2.0
*
*   Unless required by applicable law or agreed to in writing, 
* software distributed under the License is distributed on an 
* "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, 
* either express or implied.  See the License for the specific 
* language governing permissions and limitations under the 
* License.
*/
require_once 'class.leads.php';
require_once 'class.settings.php';

$HAPIKey = 'some-really-long-api-key';


/*/Exercise Leads API
$leads = new Leads($HAPIKey);
$params = array('max'=>5, 'excludeConversionEvents'=>'true');
print_r($base->get_leads($params));

$lead = $base->get_lead('8a706adf32896eda0132896fa1d3000b');
$newvalues = array('firstName'=>'from','lastName'=>'haPiHP');
echo $base->update_lead('8a706adf32896eda0132896fa1d3000b',$newvalues);        
echo $base->close_lead('8a706adf32896eda0132896fa1d3000b',1234567890123);
echo $lead->guid;

$postValues = array('email'=>'haPiHPtest@hubspot.com',
                    'firstName'=>'Posted',
                    'lastName'=>'By',
                    'company'=>'haPiHP');
//echo $base->add_lead('http://somedomain.hubspot.com/?app=leaddirector&FormName=contactUs', $postValues);
*/
//Exercise Settings API
    $settings = new Settings($HAPIKey);
    //Get all settings
    //print_r($settings->get_settings());
    //Get a specific setting
    print_r($settings->get_setting('BG:FollowMeEnabled'));
    //Update a setting
    //echo $settings->update_setting('BenSmith','true');
    echo $settings->delete_setting('BenSmith');
?>
