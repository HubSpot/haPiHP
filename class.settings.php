<?php
require_once('class.baseclient.php');

class Settings extends BaseClient {
    //Client for HubSpot Leads API.

    //Define required client variables
    protected $API_PATH = 'settings';    
    protected $API_VERSION = 'v1';
    
    /**
    * Get a list of settings
    *
    * @returns Array of Settings as stdObjects
    *
    * @throws exception
    **/
    public function get_settings() {
        $endpoint = 'settings';
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,null))); 
        } catch (Exception $e) {
            throw new Exception('Unable to retrieve settings: ' . $e);
        }
    }

    /**
    * Get a specific setting
    *
    * @param settingName: String value of setting name to be retrieved
    *
    * @returns Setting as stdObject
    *
    * @throws exception
    **/
    public function get_setting($settingName) {
        $endpoint = 'settings';
        $params = array('name'=>$settingName);
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params))); 
        } catch (Exception $e) {
            throw new Exception('Unable to retrieve setting: ' . $e);
        }
    }

    /**
    * Update a setting value
    *
    * @param settingName: String name of the setting to be updated
    * @param value: String value that setting should be valued to
    *
    * @returns Body of POST request
    *
    * @throws exception
    **/
    public function update_setting($settingName, $value) {
        $endpoint = 'settings';
        $params = array('name'=>$settingName, 'value'=>$value);
        try {
            return $this->execute_post_request($this->get_request_url($endpoint,null), $params);
        } catch (Exception $e) {
            throw new Exception('Unable to update setting: ' . $e);
        }  

    }

    /**
    * Delete a setting
    *
    * @param settingName: String name of the setting to be deleted
    *
    * @returns Body of DELETE request
    *
    * @throws exception
    **/
    public function delete_setting($settingName) {
        $endpoint = 'settings';
        $params = array('name'=>$settingName);
        $body = $this->array_to_params($params);
        try {
            return $this->execute_delete_request($this->get_request_url($endpoint,null), $body);
        } catch (Exception $e) {
            throw new Exception('Unable to delete setting: ' . $e);
        }      
    }
}

