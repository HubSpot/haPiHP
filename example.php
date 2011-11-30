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
require_once 'class.leadnurturing.php';
require_once 'class.prospects.php';
require_once 'class.keywords.php';
require_once 'class.blog.php';

$HAPIKey = 'demo';

//Exercise Blog API
    $blogs = new Blog($HAPIKey);
    $content_type = 'json';

    //List blogs for a specific portal (API key)
    $params = array('max'=>1);
    print_r($blogs->get_blogs($params, $content_type));

    //Get info about a specific blog
    $params = array();
    print_r($blogs->get_blog($params, '0d61e4ca-e395-4c1c-8766-afaa48bf68db', $content_type));

    //List posts for a specific blog
    $params = array('max'=>2);
    print_r($blogs->get_posts($params, '0d61e4ca-e395-4c1c-8766-afaa48bf68db', $content_type));

    //List comments for a specific blog
    $params = array('max'=>2);
    print_r($blogs->get_comments($params, '0d61e4ca-e395-4c1c-8766-afaa48bf68db', $content_type));

    //Get information about a specific blog post
    $params = array();
    print_r($blogs->get_post($params, '71e3900b-c02e-420f-9686-49a1706d56a2', $content_type));

    //List comments for a specific post
    $params = array();
    print_r($blogs->get_post_comments($params, '71e3900b-c02e-420f-9686-49a1706d56a2', $content_type));

    //Get information about a specific comment
    $params = array();
    print_r($blogs->get_comment($params, 'a180af6e-39ea-46f2-a751-c56312d48269', $content_type));

    //Create a blog post in a specific blog
    $tags = array('hapihp tag 1', 'hapihp tag 2');
    echo $blogs->create_post('0d61e4ca-e395-4c1c-8766-afaa48bf68db', 'Test Author', 'testapi@hubspot.com', 'find this one', 'testing hapihp summary', 'this is the content for testing hapihp', $tags);

    //Update a blog post, identified by its guid
    $tags = array('hapihp updated tag 1', 'hapihp updated tag 2');
    $keywords = array('i am','a keyword','wow','really?');
    //($post_guid, $title, $summary, $post_content, $tags, $meta_desc, $keywords)
    echo $blogs->update_post('ae15391a-7bd9-454d-b51b-5c480a010497', 'new improves Updated title', 'updated summary', 'updated content', $tags, 'updated meta desc', $keywords);

    //Publish a blog post
    date_default_timezone_set('America/New_York');
    $future = date('G');
    if ($future < 23) {
        $future = $future + 1;
    } else { 
        $future = 1; 
    }
    $days = date('Y-m-d');
    $times = date('i:s');
    $publish_time = $days.'T'.$future.':'.$times.'Z';
    
    echo $blogs->publish_post('ae15391a-7bd9-454d-b51b-5c480a010497', $publish_time, 'false');

    //Create a blog comment
    echo $blogs->create_comment('ae15391a-7bd9-454d-b51b-5c480a010497', 'hapihp comment Author', 'hapihp@hs.com', 'http://hubspot.com', 'hapihp test comment created a new one now');


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
    
//Exercise Lead Nurturing API
    $nurture = new LeadNurturing($HAPIKey);
    
    //Get all campaigns
    print_r($nurture->get_campaigns(false));
    
    //Get members for campaign
    print_r($nurture->get_campaign_members('2bb746ad-182f-4a47-a363-5668246f9ce2'));
    
    //Get campaign history for a lead
    print_r($nurture->get_campaign_history('8a706adf33a131b40133a1323f46000d'));
    
//Exercise Prospects API
    $prospects = new Prospects($HAPIKey);
    
    //Get prospects timeline
    print_r($prospects->get_timeline(null));
    
    //Get org details
    print_r($prospects->get_organization_details('murphx innovative solutions'));
    
    //Get typeahead results
    print_r($prospects->get_typeahead('murph'));
    
    //Get search results
    print_r($prospects->get_search_results('country', 'united kingdom'));
    
    //Add a filter
    echo $prospects->add_filter('someorg');
    
    //List filters    
    print_r($prospects->get_filters());
    
    //Delete a filter
    echo $prospects->delete_filter('someorg');
    
//Exercise Keywords API
    $keywords = new Keywords($HAPIKey);
    
    //Add keyword
    $addedKeyword = json_decode($keywords->add_keyword('hapiphp'));
    print_r($addedKeyword);
    $addedGuid = $addedKeyword->keywords[0]->keyword_guid;
    
    //Get list of keywords
    print_r($keywords->get_keywords());
    
    //Get specific keyword
    print_r($keywords->get_keyword($addedGuid));
    
    //Delete specific keyword
    echo $keywords->delete_keyword($addedGuid);

?>
