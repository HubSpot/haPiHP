<?php namespace HubSpot;

use HubSpot\HubSpot\Blog;
use HubSpot\HubSpot\Contacts;
use HubSpot\HubSpot\Forms;
use HubSpot\HubSpot\Keywords;
use HubSpot\HubSpot\LeadNurturing;
use HubSpot\HubSpot\Leads;
use HubSpot\HubSpot\Lists;
use HubSpot\HubSpot\MarketPlace;
use HubSpot\HubSpot\Properties;
use HubSpot\HubSpot\Settings;
use HubSpot\HubSpot\SocialMedia;
use HubSpot\HubSpot\Workflows;

class HubSpot {

    private $hapikey;

    function __construct($hapikey = null)
    {
        $this->hapikey = $hapikey;
        
        if (is_null($hapikey))
            $this->hapikey = getenv('HUBSPOT_APIKEY');
    }

    public function blog() { return new Blog($this->hapikey); }

    public function contacts() { return new Contacts($this->hapikey); }

    public function forms() { return new Forms($this->hapikey); }

    public function keywords() { return new Keywords($this->hapikey); }

    public function leadNurturing() { return new LeadNurturing($this->hapikey); }

    public function leads() { return new Leads($this->hapikey); }

    public function lists() { return new Lists($this->hapikey); }

    public function marketPlace() { return new MarketPlace($this->hapikey); }

    public function properties() { return new Properties($this->hapikey); }

    public function settings() { return new Settings($this->hapikey); }

    public function socialMedia() { return new SocialMedia($this->hapikey); }

    public function workflows() { return new WorkFlows($this->hapikey); }
}
