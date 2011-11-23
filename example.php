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
require_once 'class.events.php';

$HAPIKey = 'demo';


//Exercise Leads API
    $leads = new Leads($HAPIKey);
    
    //Get list of leads
    $params = array('max'=>5, 'excludeConversionEvents'=>'true');
    print_r($leads->get_leads($params));

    //Get specific lead
    $lead = $leads->get_lead('8a41f2f22913e087012913e0b4b90011');
    echo $lead->guid;
    
    //Update a lead 
    $newvalues = array('firstName'=>'from','lastName'=>'haPiHP');
    echo $leads->update_lead('8a41f2f22913e087012913e0b4b90011',$newvalues);        

    //Close a lead
    echo $leads->close_lead('8a41f2f22913e087012913e0b4b90011',1234567890123);

    //Add a lead
    $postValues = array('email'=>'haPiHPtest@hubspot.com',
                        'firstName'=>'Posted',
                        'lastName'=>'By',
                        'company'=>'haPiHP');
    echo $leads->add_lead('http://demohubapi.app6.hubspot.com/?app=leaddirector&FormName=testform', $postValues);

    //List Webhooks
    print_r($leads->get_webhooks());

    //Register Webhook
    echo $leads->register_webhook('https://www.example.com');

//Exercise Settings API
    $settings = new Settings($HAPIKey);

    //Get all settings
    print_r($settings->get_settings());

    //Get a specific setting
    print_r($settings->get_setting('facebeezy'));

    //Update a setting
    echo $settings->update_setting('BenSmith','true');
    echo $settings->delete_setting('BenSmith');

//Exercise Marketing Events API
    $events = new Events($HAPIKey);

    //Get all events
    print_r($events->get_events());

    //Add an event
    echo $events->add_event('This is my test event',null,'http://www.test.com', 'test');
?>
