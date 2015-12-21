<?php
/**
* Copyright 2013 HubSpot, Inc.
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

// Client for HubSpot Company API
// http://developers.hubspot.com/docs/methods/companies/companies-overview
class HubSpot_Companies extends HubSpot_BaseClient{

	// Define required client variables
    protected $API_PATH    = 'companies';
    protected $API_VERSION = 'v2';


    /**
    * Create a Company
    * http://developers.hubspot.com/docs/methods/companies/create_company
    *
    * @param params: array of properties and property values for new company, email is required
    *
    * @return Response body with JSON object for created company from HTTP POST request
    *
    * @throws HubSpot_Exception
    **/
    public function create_company($params){
    	$endpoint = 'companies';
    	$properties = array();
    	foreach ($params as $key => $value) {
    		array_push($properties, array("name"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
    	try{
    		return json_decode($this->execute_JSON_post_request($this->get_request_url($endpoint,null),$properties));
    	} catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to create company: ' . $e);
    	}
    }


    /**
    * Update a Company
    * http://developers.hubspot.com/docs/methods/companies/update_company
    *
    * @param cid   : Unique ID for the company to update
    * @param params: array of properties and property values for company
    *
    * @return Response body from HTTP POST request
    *
    * @throws HubSpot_Exception
    **/
    public function update_company($cid, $params){
    	$endpoint = 'companies/'.$cid;
    	$properties = array();
    	foreach ($params as $key => $value) {
    		array_push($properties, array("name"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
    	try{
			return json_decode($this->execute_JSON_post_request($this->get_request_url($endpoint,null),$properties));
    	} catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to update company: ' . $e);
    	}
    }


    /**
	* Delete a Company
    * http://developers.hubspot.com/docs/methods/companies/delete_company
	*
	* @param cid: Unique ID for the Company to delete
	*
	* @return Response body from HTTP POST request
	*
	* @throws HubSpot_Exception
    **/
    public function delete_company($cid){
    	$endpoint = 'companies/'.$cid;
    	try{
    		return json_decode($this->execute_delete_request($this->get_request_url($endpoint,null),null));
    	}
    	catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to delete company: ' . $e);
    	}
    }


    /**
    * Get recently modified Companies
    * http://developers.hubspot.com/docs/methods/companies/get_companies_modified
    *
    * @param params: array of 'count', or 'offset' for results
    *
    * @return JSON objects for recently modified Companies in portal
    *
    * @throws HubSpot_Exception
    **/
    public function get_recent_modified_companies($params){
        $endpoint = 'companies/recent/modified';
        try{
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to get companies: '.$e);
        }
    }


    /**
    * Get recently created Companies
    * http://developers.hubspot.com/docs/methods/companies/get_companies_created
    *
    * @param params: array of 'count', or 'offset' for results
    *
    * @return JSON objects for recently created Companies in portal
    *
    * @throws HubSpot_Exception
    **/
    public function get_recent_created_companies($params){
        $endpoint = 'companies/recent/created';
        try{
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to get companies: '.$e);
        }
    }


    /**
	* Get all Contacts at a Company
    * http://developers.hubspot.com/docs/methods/companies/get_company_contacts
	*
	* @param cid   : Unique ID for the Company to look-up
    * @param params: array of 'count' or 'VidOffset' for results
	*
	* @return JSON objects for all Contacts at a Company
	*
	* @throws HubSpot_Exception
    **/
    public function get_all_contacts_at_company($cid, $params){
    	$endpoint = 'companies/'.$cid.'/contacts';
    	try{
    		return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to get contacts: '.$e);
    	}
    }


    /**
    * Get all Contact IDs at a Company
    * http://developers.hubspot.com/docs/methods/companies/get_company_contacts_by_id
    *
    * @param cid   : Unique ID for the Company to look-up
    * @param params: array of 'count' or 'VidOffset' for results
    *
    * @return JSON objects for all Contacts at a Company
    *
    * @throws HubSpot_Exception
    **/
    public function get_all_contact_ids_at_company($cid, $params){
        $endpoint = 'companies/'.$cid.'/vids';
        try{
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to get contacts: '.$e);
        }
    }


    /**
	* Get Company by ID
    * http://developers.hubspot.com/docs/methods/companies/get_company
	*
	* @param cid: Unique ID for company
	*
	* @return JSON object for requested Company
	*
	* @throws HubSpot_Exception
    **/
    public function get_company_by_id($cid){
    	$endpoint = 'companies/'.$cid;
    	try{
    		return json_decode($this->execute_get_request($this->get_request_url($endpoint,null)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to get company: '.$e);
    	}
    }

    /**
	* Get Companies by domain
    * http://developers.hubspot.com/docs/methods/companies/get_companies_by_domain
	*
	* @param domain: Domain to look-up
	*
	* @return JSON object for requested Companies
	*
	* @throws HubSpot_Exception
    **/
    public function get_companies_by_domain($domain){
    	$endpoint = 'companies/domain/'.$domain;
    	try{
    		return json_decode($this->execute_get_request($this->get_request_url($endpoint,null)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to get companies: '.$e);
    	}
    }


    /**
    * Add a Contact to a Company
    * http://developers.hubspot.com/docs/methods/companies/add_contact_to_company
    *
    * @param vid: Unique ID for contact to be added
    * @param cid: Unique ID for company
    *
    * @return Response body from HTTP request
    *
    * @throws HubSpot_Exception
    **/
    public function add_contact_to_company($vid, $cid){
        $endpoint = 'companies/'.$cid.'/contacts/'.$vid;
        try{
            return json_decode($this->execute_put_request($this->get_request_url($endpoint,null), null));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to associate contact with company: '.$e);
        }
    }


    /**
    * Remove a Contact from a Company
    * http://developers.hubspot.com/docs/methods/companies/remove_contact_from_company
    *
    * @param vid: Unique ID for contact to be added
    * @param cid: Unique ID for company
    *
    * @return Response body from HTTP request
    *
    * @throws HubSpot_Exception
    **/
    public function remove_contact_from_company($vid, $cid){
        $endpoint = 'companies/'.$cid.'/contacts/'.$vid;
        try{
            return json_decode($this->execute_delete_request($this->get_request_url($endpoint,null)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to remove contact from company: '.$e);
        }
    }

}

?>