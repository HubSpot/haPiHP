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

class HubSpot_Leads extends HubSpot_BaseClient {
    //Client for HubSpot Leads API.

    //Define required client variables
    protected $API_PATH = 'leads';
    protected $API_VERSION = 'v1';

    /**
    * Get a list of leads
    *
    * @param params: Array of Leads API query filters and values
    *                See http://docs.hubapi.com/wiki/Searching_Leads for valid filters and values
    *
    * @returns Array of Leads as stdObjects
    *
    * @throws HubSpot_Exception
    **/
    public function get_leads($params) {
        $endpoint = 'list';
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to retrieve list: ' . $e);
        }

    }

    /**
    * Get a single lead
    *
    * @param leadGuid: String value of the guid for the lead to return
    *
    * @returns single Lead as stdObject
    *
    * @throws HubSpot_Exception
    **/
    public function get_lead($leadGuid) {
        $endpoint = 'lead/' . $leadGuid;
        try {
            $leadArray = json_decode('[' . $this->execute_get_request($this->get_request_url($endpoint,null)) . ']');
            return $leadArray[0];
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to retrieve lead: ' . $e);
        }
    }

    /**
    * Update a single lead
    *
    * @param leadGuid: String value of the guid for the lead to update
    * @param updateData: Array of fields and values to update
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws HubSpot_Exception
    **/
    public function update_lead($leadGuid, $updateData) {
        $endpoint = 'lead/' . $leadGuid;
        $updateData['id'] = $leadGuid;
        $body = json_encode($updateData);
        try {
            return $this->execute_put_request($this->get_request_url($endpoint,null), $body);
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to update lead: ' . $e);
        }
    }

    /**
    * Update a single lead to a customer
    *
    * @param leadGuid: String value of the guid for the lead to update
    * @param closeDate: String value of the close date/time in ms since epoch
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws HubSpot_Exception
    **/
    public function close_lead($leadGuid, $closeDate) {
        $endpoint = 'lead/' . $leadGuid;
        $updateData = array();
        $updateData['id'] = $leadGuid;
        $updateData['closedAt'] = $closeDate;
        $updateData['isCustomer'] = 'true';
        $body = json_encode($updateData);
        try {
            return $this->execute_put_request($this->get_request_url($endpoint,null), $body);
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to close lead: ' . $e);
        }
    }

    /**
    * Adds a single lead to HubSpot via the Lead Tracking API
    *
    * @param formURL: String value fo the form URL to POST to
    * @param postFields: Array of fields and values to post to HubSpot
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws HubSpot_Exception
    **/
    public function add_lead($formURL, $postFields) {
        $body = $this->array_to_params($postFields);
        try {
            return $this->execute_post_request($formURL, $body);
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to add lead: ' . $e);
        }
    }

    /**
    * Lists registered webhooks
    *
    * @returns Array of webhooks as stdObjects
    *
    * @throws HubSpot_Exception
    **/
    public function get_webhooks() {
        $endpoint = 'callback-url';
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,null)));
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to retrieve webhooks: ' . $e);
        }
    }

    /**
    * Registers a webhook
    *
    * @param callbackURL: The callback url to register
    *
    * @returns Body of POST request
    *
    * @throws HubSpot_Exception
    **/
    public function register_webhook($callbackURL) {
        $endpoint = 'callback-url';
        if ($this->isBlank($callbackURL)) {
            throw new HubSpot_Exception('callbackURL is required');
        }
        $params = array('url'=>$callbackURL);
        $body = $this->array_to_params($params);
        try {
            return $this->execute_post_request($this->get_request_url($endpoint,null), $body, true);	// new
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to register webhook: ' . $e);
        }
    }

    /**
    * Deletes a webhook
    *
    * @param webhookGuid: The guid of the webhook to delete
    *
    * @returns Body of DELETE request
    *
    * @throws HubSpot_Exception
    **/
    public function delete_webhook($webhookGuid) {
        if ($this->isBlank($webhookGuid)) {
            throw new HubSpot_Exception('callbackGuid is required');
        }
        $endpoint = 'callback-url/' . $webhookGuid;
        try {
            return $this->execute_delete_request($this->get_request_url($endpoint,null), null);
        } catch (HubSpot_Exception $e) {
            throw new HubSpot_Exception('Unable to delete webhook: ' . $e);
        }
    }

}