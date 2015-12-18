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

// Client for HubSpot Deals API
// http://developers.hubspot.com/docs/methods/deals/deals_overview
class HubSpot_Deals extends HubSpot_BaseClient{

	// Define required client variables
	protected $API_PATH = 'deals';
	protected $API_VERSION = 'v1';


    /**
    * Create a Deal
    * http://developers.hubspot.com/docs/methods/deals/create_deal
    *
    * @param params: array of properties and property values for new deals
    *
    * @return Response body with JSON object for created Deal from HTTP POST request
    *
    * @throws HubSpot_Exception
    **/
    public function create_deal($params){
    	$endpoint = 'deal';
    	$properties = array();
    	foreach ($params as $key => $value) {
    		array_push($properties, array("property"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
    	try{
    		return json_decode($this->execute_JSON_post_request($this->get_request_url($endpoint,null),$properties));
    	} catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to create deal: ' . $e);
    	}
    }


    /**
    * Update a Deal
    * http://developers.hubspot.com/docs/methods/deals/update_deal
    *
    * @param params: array of properties and property values for deal
    *
    * @return Response body from HTTP POST request
    *
    * @throws HubSpot_Exception
    **/
    public function update_deal($vid, $params){
    	$endpoint = 'deal/'.$vid;
    	$properties = array();
    	foreach ($params as $key => $value) {
    		array_push($properties, array("property"=>$key,"value"=>$value));
    	}
    	$properties = json_encode(array("properties"=>$properties));
    	try{
			return json_decode($this->execute_JSON_post_request($this->get_request_url($endpoint,null),$properties));
    	} catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to update deal: ' . $e);
    	}
    }


    /**
	* Delete a Deal
    * http://developers.hubspot.com/docs/methods/deals/delete_deal
	*
	* @param vid: Unique ID for the deal
	*
	* @return Response body from HTTP POST request
	*
	* @throws HubSpot_Exception
    **/
    public function delete_deal($vid){
    	$endpoint = 'deal/'.$vid;
    	try{
    		return json_decode($this->execute_delete_request($this->get_request_url($endpoint,null),null));
    	}
    	catch (HubSpot_Exception $e) {
    		throw new HubSpot_Exception('Unable to delete deal: ' . $e);
    	}
    }


    /**
	* Get recently modified Deals
    * http://developers.hubspot.com/docs/methods/deals/get_deals_modified
	*
	* @param params: array of 'count', or 'offset' for results
	*
	* @return JSON objects for recently modified Deals in portal
	*
	* @throws HubSpot_Exception
    **/
    public function get_recent_modified_deals($params){
    	$endpoint = 'deal/recent/modified';
    	try{
    		return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to get deals: '.$e);
    	}
    }


    /**
    * Get recently created Deals
    * http://developers.hubspot.com/docs/methods/deals/get_deals_created
    *
    * @param params: array of 'count', or 'offset' for results
    *
    * @return JSON objects for recently created Deals in portal
    *
    * @throws HubSpot_Exception
    **/
    public function get_recent_created_deals($params){
        $endpoint = 'deal/recent/created';
        try{
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to get deals: '.$e);
        }
    }


    /**
	* Get Deal by ID
    * http://developers.hubspot.com/docs/methods/deals/get_deal
	*
	* @param vid: Unique ID for deal
	*
	* @return JSON object for requested Deal
	*
	* @throws HubSpot_Exception
    **/
    public function get_deal_by_id($vid){
    	$endpoint = 'deal/'.$vid;
    	try{
    		return json_decode($this->execute_get_request($this->get_request_url($endpoint,null)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to get deal: '.$e);
    	}
    }


    /**
	* Associate a Deal with a contact or company
    * http://developers.hubspot.com/docs/methods/deals/associate_deal
	*
	* @param object_type : 'CONTACT' or 'COMPANY' - which type of association to create
    * @param object_id   : Unique ID of the contact or company to associate
	*
	* @return Response body from HTTP request
	*
	* @throws HubSpot_Exception
    **/
    public function add_deal_association($vid, $object_type, $object_id ){
    	$endpoint = 'deal/'.$vid.'/associations/'.strtoupper($object_type);
        $params = array( 'id' => $object_id );
    	try{
    		return json_decode($this->execute_put_request($this->get_request_url($endpoint,$params)));
    	}
    	catch(HubSpot_Exception $e){
    		throw new HubSpot_Exception('Unable to associate ' . $object_type . ' with deal: '.$e);
    	}
    }


    /**
    * Remove association of a Deal with a contact or company
    * http://developers.hubspot.com/docs/methods/deals/delete_association
    *
    * @param object_type : 'CONTACT' or 'COMPANY' - which type of association to create
    * @param object_id   : Unique ID of the contact or company to associate
    *
    * @return Response body from HTTP request
    *
    * @throws HubSpot_Exception
    **/
    public function remove_deal_association($vid, $object_type, $object_id ){
        $endpoint = 'deal/'.$vid.'/associations/'.strtoupper($object_type);
        $params = array( 'id' => $object_id );
        try{
            return json_decode($this->execute_delete_request($this->get_request_url($endpoint,$params)));
        }
        catch(HubSpot_Exception $e){
            throw new HubSpot_Exception('Unable to associate ' . $object_type . ' with deal: '.$e);
        }
    }
}

?>