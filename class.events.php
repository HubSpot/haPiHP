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
require_once('class.baseclient.php');

class HubSpot_Events extends HubSpot_BaseClient {
    //Client for HubSpot Marketing Events API.

    //Define required client variables
    protected $API_PATH = 'events';
    protected $API_VERSION = 'v1';

    /**
    * Get a list of events
    *
    * @returns Array of Marketing Events as stdObjects
    *
    * @throws HubSpot_Exception
    **/
    public function get_events() {
        $endpoint = 'events';
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,null)));
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to retrieve events: ' . $e);
        }
    }

    /**
    * Add a Marketing Event
    *
    * @param description: String description up to 150 chars
    * @param createDate: String ms since epoch (optional)
    * @param eventURL: String URL for event up to 255 chars (optional)
    * @param eventType: String short tag describing event (extremely optional)
    *
    * @returns Body of POST request
    *
    * @throws HubSpot_Exception
    **/
    public function add_event($description, $createDate, $eventURL, $eventType) {
        $endpoint = 'events';

        if ($this->isBlank($description)) {
            throw new HubSpot_Exception('Description is required');
        }
        if (strlen($description) > 150) {
            throw new HubSpot_Exception('Description limited to 120 characters');
        }
        if (strlen($eventType) > 20) {
            throw new HubSpot_Exception('Event Type limited to 20 characters');
        }
        if (strlen($eventURL) > 255) {
            throw new HubSpot_Exception('Event URL limited to 255 characters');
        }

        $params = array('description'=>$description);
        if (!$this->isBlank($createDate)) {
            $params['createDate'] = $createDate;
        }
        if (!$this->isBlank($eventURL)) {
            $params['url'] = $eventURL;
        }
        if (!$this->isBlank($eventType)) {
            $params['eventType'] = $eventType;
        }
        $body = $this->array_to_params($params);
        try {
            return $this->execute_post_request($this->get_request_url($endpoint,null), $body);
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to add event: ' . $e);
        }
    }

}