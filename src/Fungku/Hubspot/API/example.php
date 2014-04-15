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
//require_once 'class.events.php';
require_once 'class.leadnurturing.php';
require_once 'class.prospects.php';
require_once 'class.keywords.php';
require_once 'class.blog.php';
require_once 'class.contacts.php';
require_once 'class.workflows.php';
require_once 'class.forms.php';
require_once 'class.lists.php';
require_once 'class.properties.php';
require_once 'class.socialmedia.php';

$HAPIKey = 'demo';
/*
//Exercise Blog API
    $blogs = new HubSpot_Blog($HAPIKey);
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
    $leads = new HubSpot_Leads($HAPIKey);
    
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
    $settings = new HubSpot_Settings($HAPIKey);

    //Get all settings
    print_r($settings->get_settings());
    
    //Get a specific setting
    print_r($settings->get_setting('facebeezy'));
    
    //Update a setting
    echo $settings->update_setting('BenSmith','true');
    echo $settings->delete_setting('BenSmith');

//Exercise Marketing Events API
    $events = new HubSpot_Events($HAPIKey);
    
    //Get all events
    print_r($events->get_events());
    
    //Add an event
    echo $events->add_event('This is my test event',null,'http://www.test.com', 'test');

//Exercise Lead Nurturing API
    $nurture = new HubSpot_LeadNurturing($HAPIKey);
    
    //Get all campaigns
    print_r($nurture->get_campaigns(false));
    
    //Get members for campaign
    print_r($nurture->get_campaign_members('2bb746ad-182f-4a47-a363-5668246f9ce2'));
    
    //Get campaign history for a lead
    print_r($nurture->get_campaign_history('8a706adf33a131b40133a1323f46000d'));
    
//Exercise Prospects API
    $prospects = new HubSpot_Prospects($HAPIKey);
    
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
    $keywords = new HubSpot_Keywords($HAPIKey);
    
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
*/
//Excercise Contacts API
/*    $contacts = new HubSpot_Contacts($HAPIKey);

    $unique_email = 'testemail+'.uniqid().'@emailtest.com';
        //Create Contact
    $params =  array('email' => $unique_email, 'firstname' => 'Webster' );
    $createdContact = $contacts->create_contact($params);
    print_r($createdContact);
    $newly_created_vid = $createdContact->{'vid'};

        //Update Contact
    $params =  array('lastname' => 'Gordon' );
    $updatedContact = $contacts->update_contact($newly_created_vid,$params);
    print_r($updatedContact);

        //Delete Contact
    $deletedContact = $contacts->delete_contact($newly_created_vid);
    print_r($deletedContact);

        //Get all Contacts
        $contacts_batch1 = $contacts->get_all_contacts();
        print_r($contacts_batch1);
        $offset = $contacts_batch1->{'vid-offset'};
        $contacts_batch2 = $contacts->get_all_contacts(array('vidOffset'=>$offset));
        print_r($contacts_batch2);

        //Get recent Contacts
        $contacts_recent_batch1 = $contacts->get_recent_contacts();
        print_r($contacts_recent_batch1);
        $offset = $contacts_recent_batch1->{'vid-offset'};
        $contacts_recent_batch2 = $contacts->get_recent_contacts(array('vidOffset'=>$offset));
        print_r($contacts_recent_batch2);

        //Get Contact by ID, email, usertoken
        $contactByID = $contacts->get_contact_by_id('151682');
        print_r($contactByID);
        $contactByEmail = $contacts->get_contact_by_email('wgordon+test@hubspot.com');
        print_r($contactByEmail);
        $contactByUsertoken = $contacts->get_contact_by_usertoken('770f8023b3e6b10fc080155c4ebdfc0e');
        print_r($contactByUsertoken);

        //Search Contacts
        $contactsSearchResult = $contacts->search_contacts(array('q'=>'test'));
        print_r($contactsSearchResult);

        //Get Contacts statistics
        $contactsStats = $contacts->get_contacts_statistics();
        print_r($contactsStats);


    //Exercise Workflows API
        $workflows = new HubSpot_Workflows($HAPIKey);

        //Get all Workflows
        $all_workflows = $workflows->get_all_workflows();
        print_r($all_workflows);

        //Get Workflow by ID
        $workflow_from_id = $workflows->get_workflow_by_ID('23525');
        print_r($workflow_from_id);

        //Enroll contact in Workflow
        $enrolled_contact = $workflows->enroll_contact_in_workflow('23525','danna.biers.18@facebook.com');
        print_r($enrolled_contact);

        //Unenroll contact from Workflow
        $unenrolled_contact = $workflows->unenroll_contact_from_workflow('23525','danna.biers.18@facebook.com');
        print_r($unenrolled_contact);

        //Get current enrollments for Contact
        $contact_enrollments = $workflows->get_current_enrollments('151421');
        print_r($contact_enrollments);

        //Get log events for contact by ID in Workflow by ID
        $workflow_logs = $workflows->get_log_events('23525','151421');
        print_r($workflow_logs);

        //Get upcoming events for contact by ID in Workflow by ID
        $workflow_upcoming = $workflows->get_upcoming_events('23525','151421');
        print_r($workflow_upcoming);



    //Exercise Forms API
        $forms = new HubSpot_Forms($HAPIKey);
        $uid = uniqid();
        $form_data = array('name'=>'Test Form'.$uid, 'method'=>'POST', 'submitText'=>'Sign Up','notifyRecipients'=>'youremail@company.com' );
        $fields = array(array('name'=>'firstname','label'=>'First Name','description'=>'test field','groupName'=>'contactInformation','type'=>'string','fieldType'=>'text',
            'displayOrder'=>0,'required'=>'true','enabled'=>'true','hidden'=>'false','defaultValue'=>'','isSmartField'=>'false','options'=>null,'selectedOptions'=>null),
        array('name'=>'email','label'=>'Email','groupName'=>'contactInformation','type'=>'string','fieldType'=>'text',
            'displayOrder'=>1,'required'=>'true','enabled'=>'true','hidden'=>'false','defaultValue'=>'','options'=>null));

        //Create a form
        $new_form = $forms->create_form($form_data,$fields);
        print_r($new_form);
        $new_form_guid = $new_form->{'guid'};

        //Get all forms
        //$all_forms = $forms->get_forms();
        //print_r($all_forms);


        //Update Form
        $update_form_data = array('name'=>'Updated test form name'.$uid);
        $updated_form = $forms->update_form($new_form_guid,$update_form_data,$fields);
        print_r($updated_form);

        //Get Form by ID
        $specific_form = $forms->get_form_by_id($new_form_guid);
        print_r($specific_form);

        //Get form fields
        $form_fields = $forms->get_form_fields($new_form_guid);
        print_r($form_fields);

        //Get specific form field
       // $specific_form_field = $forms->get_single_form_field($new_form_guid,'firstname');
        //print_r($specific_form_field);

        //Submit a form
        $submitted_form_fields = array('firstname'=>'Webster','lastname'=>'Gordon','email'=>'newtestemail'.$uid.'@testing.com');
        $hs_context = array('hutk'=>'12345678'.$uid,'ipAddress'=>'1.2.3.4','pageUrl'=>'http://demo.hubapi.com/contact',
            'pageName'=>'Contact Us','redirectUrl'=>'http://demo.hubapi.com/thank-you');
        $submitted_form = $forms->submit_form('62515',$new_form_guid,$submitted_form_fields,$hs_context);
        print_r($submitted_form);

        //Delete a Form
        $deleted_form = $forms->delete_form($new_form_guid);
        print_r($deleted_form);

    //Exercise Lists API
        $lists = new HubSpot_Lists($HAPIKey);

        //Create a contact List
        $list_array = array('name'=>'Tweeters','dynamic'=>false,'portalId'=>'62515','filters'=>
            array(array(array('operator'=>'IS_NOT_EMPTY','property'=>'twitterhandle','type'=>'string'))));
        $new_list = $lists->create_list($list_array);
        $list_id = $new_list->{'listId'};
        print_r($new_list);

        //Update a contact List
        $updated_list_array = array('name'=>'Tweeters and Hubspotters','dynamic'=>false,'portalId'=>'62515','filters'=>
            array(array(array('operator'=>'IS_NOT_EMPTY','property'=>'twitterhandle','type'=>'string'),
                array('operator'=>'EQ','value'=>'Hubspot','property'=>'company','type'=>'string'))));
        $updated_list = $lists->update_list($list_id,$updated_list_array);
        print_r($updated_list);

        //Get List by ID
        print_r($lists->get_list($list_id));

        //Get Lists
        $some_lists = $lists->get_lists(array('offset'=>5));
        var_dump($some_lists);

        //Get Static Lists
        $static_lists = $lists->get_static_lists(null);
        print_r($static_lists);

        //Get dynamic Lists
        $dynamic_lists = $lists->get_dynamic_lists(null);
        print_r($dynamic_lists);

        //Get Contacts from List
        $contacts_from_list = $lists->get_contacts_in_list(null,$list_id);
        print_r($contacts_from_list);
        if($contacts_from_list->{'has-more'}){
            $next_contacts_batch = $lists->get_contacts_in_list(array('vidOffset'=>$contacts_from_list->{'vid-offset'}));
            print_r($next_contacts_batch);
        }

        //Get recent Contacts from List
        $recent_contacts = $lists->get_recent_contacts_in_list(null,$list_id);
        print_r($recent_contacts);

        //Refresh list
        $refreshed_list = $lists->refresh_list($list_id);
        print_r($refreshed_list);

        //Add contact to List
        $contacts_to_add = array(152842,152843);
        $added_contacts = $lists->add_contacts_to_list($contacts_to_add,$list_id);
        print_r($added_contacts);

        //Remove contacts from List
        $removed_contacts = $lists->remove_contacts_from_list(array(152842),$list_id);
        print_r($removed_contacts);

        //Delete List
        $deleted_list = $lists->delete_list($list_id);
        print_r($deleted_list);


    //Exercise Properties API
        $properties = new HubSpot_Properties($HAPIKey);

        //Get all Properties
        $all_props = $properties->get_all_properties();
        print_r($all_props);

        //Create new Property
        $new_prop_info  = array('label'=>'Favorite Boston NBA Team','name'=>'favbostonnbateam','description'=>'Your favorite NBA team in the Boston Area',
                            'groupName'=>'contactinformation','type'=>'enumeration','fieldType'=>'checkbox','formField'=>'true','displayOrder'=>0,   
                            'options'=>array(array('label'=>'Boston Celtics','value'=>'Boston Celtics','displayOrder'=>0)));
        $new_prop = $properties->create_property('favbostonnbateam',$new_prop_info);
        print_r($new_prop);

        //Update property
        $updated_prop_info = array('label'=>'Favorite Boston NBA Team','name'=>'favbostonnbateam','description'=>'Your favorite NBA team in the Boston Area',
                            'groupName'=>'contactinformation','type'=>'enumeration','fieldType'=>'checkbox','formField'=>'true','displayOrder'=>0,   
                            'options'=>array(array('label'=>'Boston Celtics','value'=>'Boston Celtics','displayOrder'=>0),
                                        array('label'=>'I do not watch basketball','value'=>'I do not watch basketball','displayOrder'=>1)));
        $updated_prop = $properties->update_property('favbostonnbateam',$updated_prop_info);

        //Delete property
        $deleted_prop = $properties->delete_property('favbostonnbateam');
        print_r($deleted_prop);

        //Get Property Group
        $group = $properties->get_property_group('contactinformation');
        print_r($group);

        //Create Property Group
        $group_info = array('name'=>'newpropgroup','displayName'=>'A New Property Group','displayOrder'=>4);
        $new_group = $properties->create_property_group('newpropgroup',$group_info);
        print_r($new_group);

        //Update Property Group
        $updated_group_info = array('name'=>'newpropgroup','displayName'=>'A Newer Property Group','displayOrder'=>4);
        $updated_group = $properties->update_property_group('newpropgroup',$updated_group_info);
        print_r($updated_group);

        //Delete Property Group
        $deleted_group = $properties->delete_property_group('newpropgroup');
        print_r($deleted_group);

*/
    //Exercise Social Media API
        $social = new HubSpot_SocialMedia($HAPIKey);

        //Get Publishing Channels
        $channels = $social->get_publishing_channels();
        print_r($channels);

        //Get specific Channel
        $channel = $social->get_publishing_channel('7c13e300-e43f-3aa0-a842-93956cb214e9');
        print_r($channel);

        //Get Broadcasts
        $broadcasts = $social->get_broadcasts(array('status'=>'success','since','1356036460644','count'=>'100'));
        print_r($broadcasts);

        //Get specific Broadcast
        $broadcast = $social->get_broadcast('8c3dc6fb-2c7e-4719-b4b9-521794289cfc');
        print_r($broadcast);

        //Create a Broadcast
        $new_broadcast = $social->create_broadcast(array('channelGuid'=>'7c13e300-e43f-3aa0-a842-93956cb214e9','triggerAt'=>strval(time()*1000+50000),
                                                    'content'=>array('body'=>'Here is an awesome new Social Media message')));
        print_r($new_broadcast);

        //Cancel a Broadcast
        $broadcast_guid = $new_broadcast->{'broadcastGuid'};
        $deleted_broadcast = $social->cancel_broadcast($broadcast_guid);
        print_r($deleted_broadcast);

        ?>
