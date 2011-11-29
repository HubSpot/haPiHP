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

class Blog extends BaseClient {
    //Client for HubSpot Lead Nurturing API.

    //Define required client variables
    protected $API_PATH = 'blog';    
    protected $API_VERSION = 'v1';
    
    //Get all blogs for a specific portal, identified by its API key
    public function get_blogs($params, $content_type) {
        $endpoint = 'list.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint,$params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get information about a specific blog
    public function get_blog($params, $guid, $content_type) {
        $endpoint = $guid . '.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get post from a specific blog
    public function get_posts($params, $guid, $content_type) {
        $endpoint = $guid . '/posts.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get all comments for a specific blog
    public function get_comments($params, $guid, $content_type) {
        $endpoint = $guid . '/comments.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get information about a specific blog post
    public function get_post($params, $guid, $content_type) {
        $endpoint = 'posts/' . $guid . '.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get comments for a specific blog post
    public function get_post_comments($params, $post_guid, $content_type) {
        $endpoint = 'posts/' . $post_guid . '/comments.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get information about a specific comment
    public function get_comment($params, $comment_guid, $content_type) {
        $endpoint = 'comments/' . $comment_guid . '.' . $content_type;
        
        if ($content_type == 'json') {
            try {
                return json_decode($this->execute_get_request($this->get_request_url($endpoint, $params))); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else if ($content_type == 'atom') {
            try {
                return $this->execute_get_request($this->get_request_url($endpoint, $params)); 
            } catch (Exception $e) {
                throw new Exception('Unable to retrieve blogs: ' . $e);
            }
        } else {
            throw new Exception('Invalid content type, please choose either "json" or "atom"');
        }
    }
    
    //Get information about a specific comment
    public function create_post($blog_guid, $author_name, $author_email, $title, $summary, $post_content, $tags) {
        $endpoint = $blog_guid . '/posts.atom';
        
        if ($this->isBlank($title)) {
            throw new Exception('Blog title is required!');
        } else if ($this->isBlank($post_content)) {
            throw new Exception('Blog content is required!');
        } else if ($this->isBlank($author_email)) {
            throw new Exception('Author email is required!');
        }
        
        $tag_to_input = '';
        foreach ($tags as $tag) {
            $tag_to_input = $tag_to_input . '<category term="'. $tag .'" />';
        }
        
        $body = '<?xml version="1.0" encoding="utf-8"?>
            <entry xmlns="http://www.w3.org/2005/Atom">
              <title>' . $title . '</title>
                 <author>
                   <name>' . $author_name . '</name>
                   <email>' . $author_email .'</email>
                 </author>
                 <summary>' . $summary . '</summary>
                 <content type="html"><![CDATA['.$post_content.']]></content>
                 '. $tag_to_input .'
            </entry>';
        
        try {
            return $this->execute_xml_post_request($this->get_request_url($endpoint,null), $body);
        } catch (Exception $e) {
            throw new Exception('Unable to add blog post: ' . $e);
        }
    }
}

?>