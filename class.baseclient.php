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
include('class.exception.php');

class HubSpot_BaseClient {
    // HubSpot_BaseClient class to be extended by specific hapi clients

    // Declare variables
    protected $HAPIKey;
    protected $ACCESS_TOKEN;
    protected $API_PATH;
    protected $REFRESH_TOKEN;
    protected $CLIENT_ID;
    protected $API_VERSION;
    protected $isTest = false;
    protected $PATH_DIV = '/';
    protected $API_KEY_PARAM = '?hapikey=';
    protected $TOKEN_PARAM = '?access_token=';
    protected $PROD_DOMAIN = 'https://api.hubapi.com';
    protected $QA_DOMAIN = 'https://hubapiqa.com';
    protected $userAgent;    // new

    /**
     * The HTTP status of the most recent request
     *
     * @var integer
     */
    protected $lastStatus;

    /**
     * The HTTP code for a successful request
     */
    const STATUS_OK = 200;

    /**
     * The HTTP code for bad request
     */
    const STATUS_BAD_REQUEST = 400;

    /**
     * The HTTP code for unauthorized
     */
    const STATUS_UNAUTHORIZED = 401;

    /**
     * The HTTP code for resource not found
     */
    const STATUS_NOT_FOUND = 404;

    /**
    * Constructor.
    *
    *@param HAPIKey: String value of HubSpot API Key for requests
    *       access_token: String value of Hubspot OAuth Token               
    *       refresh_token: String value of refresh token given initially for OAuth
    *       client_id: Unique ID for your registered app
    *
    **/
    public function __construct($HAPIKey=null, $access_token=null, $refresh_token=null,$client_id=null,$userAgent="haPiHP default UserAgent") {    // new

        if($HAPIKey AND $access_token){
            throw new Exception("Cannot use hapikey and OAuth token", 1);
        }
        else{
            $this->HAPIKey = $HAPIKey;
            print_r("HAPIKey:".$this->HAPIKey);
            $this->ACCESS_TOKEN = $access_token;
            print_r("token:".$this->ACCESS_TOKEN);
        }
        $this->userAgent = $userAgent;    // new
    }

    /**
     * Gets the status code from the most recent curl request
     *
     * @return integer
     */
    public function getLastStatus()
    {
        return (int)$this->lastStatus;
    }

    /**
    * Returns API_PATH that is set in specific hapi clients.  All
    * clients that extend HubSpot_BaseClient should set $API_PATH to the
    * base path for the API (e.g.: the leads api sets the value to
    * 'leads')
    *
    * @throws HubSpot_Exception
    **/
    protected function get_api() {
        if ($this->isBlank($this->API_PATH)) {
            throw new HubSpot_Exception('API_PATH must be defined');
        } else {
            return $this->API_PATH;
        }
    }

    /**
    * Returns API_VERSION that is set in specific hapi clients. All
    * clients that extend HubSpot_BaseClient should set $API_VERSION to the
    * version that the client is developed for (e.g.: the leads v1
    * client sets the value to 'v1')
    *
    * @throws HubSpot_Exception
    **/
    protected function get_api_version() {
        if ($this->isBlank($this->API_VERSION)) {
            throw new HubSpot_Exception('API_VERSION must be defined');
        } else {
            return $this->API_VERSION;
        }
    }

    /**
    * Allows developer to set testing flag to true in order to
    * execute api requests against hubapiqa.com
    *
    * @param $testing: Boolean
    **/
    public function set_is_test($testing) {
        if ($testing==true) {
            $this->isTest = true;
        }
    }

    /**
    * Returns the hapi domain to use for requests based on isTesting
    *
    * @returns: String value of domain, including https protocol
    **/
    protected function get_domain() {
     if ($this->isTest == true){
         return $this->QA_DOMAIN;
     } else {
         return $this->PROD_DOMAIN;
     }
 }

    /**
    * Creates the url to be used for the api request. If OAuth token is provided but invalid, will attempt a refresh.
    *
    * @param endpoint: String value for the endpoint to be used (appears after version in url)
    * @param params: Array containing query parameters and values
    *
    * @returns String
    **/
    protected function get_request_url($endpoint,$params) {
        $paramstring = $this->array_to_params($params);
        echo $this->HAPIKey;
        if($this->HAPIKey){
            print_r("Trying to use hapikey");
            return $this->get_domain() . $this->PATH_DIV .
            $this->get_api() . $this->PATH_DIV .
            $this->get_api_version() . $this->PATH_DIV .
            $endpoint .
            $this->API_KEY_PARAM . $this->HAPIKey .
            $paramstring;
        }
        else{
            print "went to else";
            if($this->check_auth()>=400){
                print_r("Auth check failed");
                try {
                    $refreshed_token = $this->refresh_access_token($this->REFRESH_TOKEN,$this->CLIENT_ID);
                    $this->ACCESS_TOKEN = $refreshed_token['access_token'];
                    return $this->get_domain() . $this->PATH_DIV .
                    $this->get_api() . $this->PATH_DIV .
                    $this->get_api_version() . $this->PATH_DIV .
                    $endpoint .
                    $this->TOKEN_PARAM . $this->ACCESS_TOKEN .
                    $paramstring;

                } catch (HubSpot_Exception $e) {
                    print_r('Unable to refresh the OAuth token. Please provide a valid access_token or refresh_token');
                }
            }
            else{
                return $this->get_domain() . $this->PATH_DIV .
                $this->get_api() . $this->PATH_DIV .
                $this->get_api_version() . $this->PATH_DIV .
                $endpoint .
                $this->TOKEN_PARAM . $this->ACCESS_TOKEN .
                $paramstring;
            }
        }
    }

    /**
    * Creates the url to be used for the api request for Forms API
    *
    * @param endpoint: String value for the endpoint to be used (appears after version in url)
    * @param params: Array containing query parameters and values
    *
    * @returns String
    **/
    protected function get_forms_request_url($url_base,$params) {
        $paramstring = $this->array_to_params($params);
        if($this->ACCESS_TOKEN){
            return $url_base .
            $this->TOKEN_PARAM . $this->ACCESS_TOKEN .
            $paramstring;
        }
        else{
            return $url_base .
            $this->KEY_PARAM . $this->HAPIKey .
            $paramstring;
        }
    }

    /**
    * Executes HTTP GET request
    *
    * @param URL: String value for the URL to GET
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_get_request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ( $errno > 0) {
            throw new HubSpot_Exception('cURL error: ' + $error);
        } else {
            return $output;
        }
    }

    /**
    * Executes HTTP POST request
    *
    * @param URL: String value for the URL to POST to
    * @param fields: Array containing names and values for fields to post
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_post_request($url, $body, $formenc=FALSE) {    //new

        // intialize cURL and send POST data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        if ($formenc)    // new
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));    // new
            $output = curl_exec($ch);
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            $this->setLastStatusFromCurl($ch);
            curl_close($ch);
            if ($errno > 0) {
                throw new HubSpot_Exception ('cURL error: ' + $error);
            } else {
                return $output;
            }
        }

        /**
    * Executes HTTP POST request with JSON as the POST body
    *
    * @param URL: String value for the URL to POST to
    * @param fields: Array containing names and values for fields to post
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_JSON_post_request($url, $body) {    //new
        print_r("\n".$url);
        print_r("\n".$body);
        // intialize cURL and send POST data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    // new
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ($errno > 0) {
            throw new HubSpot_Exception ('cURL error: ' + $error);
        } else {
            return $output;
        }
    }

    /**
    * Executes HTTP POST request with XML as the POST body
    *
    * @param URL: String value for the URL to POST to
    * @param fields: Array containing names and values for fields to post
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_xml_post_request($url, $body) {

        // intialize cURL and send POST data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/atom+xml'));
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ($errno > 0) {
            throw new HubSpot_Exception ('cURL error: ' + $error);
        } else {
            return $output;
        }
    }

    /**
    * Executes HTTP PUT request
    *
    * @param URL: String value for the URL to PUT to
    * @param body: String value of the body of the PUT request
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_put_request($url, $body) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($body)));
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $apierr = curl_errno($ch);
        $errmsg = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ($apierr > 0) {
            throw new HubSpot_Exception('cURL error: ' + $errmsg);
        } else {
            return $result;
        }
    }

    /**
    * Executes HTTP PUT request with XML as the PUT body
    *
    * @param URL: String value for the URL to PUT to
    * @param body: String value of the body of the PUT request
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_xml_put_request($url, $body) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/atom+xml','Content-Length: ' . strlen($body)));
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $apierr = curl_errno($ch);
        $errmsg = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ($apierr > 0) {
            throw new HubSpot_Exception('cURL error: ' + $errmsg);
        } else {
            return $result;
        }
    }

    /**
    * Executes HTTP DELETE request
    *
    * @param URL: String value for the URL to DELETE to
    * @param body: String value of the body of the DELETE request
    *
    * @returns: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function execute_delete_request($url, $body) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($body)));
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $apierr = curl_errno($ch);
        $errmsg = curl_error($ch);
        $this->setLastStatusFromCurl($ch);
        curl_close($ch);
        if ($apierr > 0) {
            throw new HubSpot_Exception('cURL error: ' + $errmsg);
        } else {
            return $result;
        }
    }

    /**
    * Converts an array into url friendly list of parameters
    *
    * @param params: Array of parameters (name=>value)
    *
    * @returns String of url friendly parameters (&name=value&foo=bar)
    *
    **/
    protected function array_to_params($params) {
        $paramstring = '';
        if ($params != null) {
            foreach ($params as $parameter => $value) {
               $paramstring = $paramstring . '&' . $parameter . '=' . urlencode($value);
           }
       }
       return $paramstring;
   }

    /**
    * Utility function used to determine if variable is empty
    *
    * @param s: Variable to be evaluated
    *
    * @returns Boolean
    **/
    protected function isBlank ($s) {
        if ((trim($s)=='')||($s==null)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the status code from a curl request
     *
     * @param resource $ch
     */
    protected function setLastStatusFromCurl($ch)
    {
        $info = curl_getinfo($ch);
        $this->lastStatus = (isset($info['http_code'])) ? $info['http_code'] : null;
    }

    /**
    * Quick check of access_token
    *
    *
    * @return: Response code for request
    *
    **/
    protected function check_auth(){
        $url = 'https://api.hubapi.com/contacts/v1/properties/email?access_token='.$this->ACCESS_TOKEN;
        print_r($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);  
        $output = curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response_code;
    }
    /**
    * Refresh OAuth token
    *
    * @param refresh_token: The refresh token for your portal
    * @param client_id: Unique ID for your app, generated when the app is registered
    *
    * @return: Body of request result
    *
    * @throws HubSpot_Exception
    **/
    protected function refresh_access_token($refresh_token, $client_id){
        if($refresh_token AND $client_id){
            $url = 'https://api.hubapi.com/auth/v1/refresh';
            $body = 'refresh_token='.$refresh_token.'&client_id='.$client_id.'&grant_type=refresh_token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);    // new
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); 
        $output = curl_exec($ch);
        $apierr = curl_errno($ch);
        $errmsg = curl_error($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $output_array = json_decode($output);
        if ($response_code<400) {
            return $output_array;
        } else {
            throw new HubSpot_Exception("cURL error: " + $errmsg);
            
        }
    }
    else{
        throw new HubSpot_Exception("Please provide a refresh_token and client_id");
    }


}


}
