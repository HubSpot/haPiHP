<?php

namespace Fungku\HubSpot;

use Fungku\HubSpot\API\Blog;
use Fungku\HubSpot\API\Contacts;
use Fungku\HubSpot\API\Forms;
use Fungku\HubSpot\API\Keywords;
use Fungku\HubSpot\API\LeadNurturing;
use Fungku\HubSpot\API\Leads;
use Fungku\HubSpot\API\Lists;
use Fungku\HubSpot\API\MarketPlace;
use Fungku\HubSpot\API\Properties;
use Fungku\HubSpot\API\Settings;
use Fungku\HubSpot\API\SocialMedia;
use Fungku\HubSpot\API\Workflows;

class HubSpot {
	
	public function blog($HAPIKey) { return new Blog($HAPIKey);	}

	public function contacts($HAPIKey) { return new Contacts($HAPIKey);	}

	public function forms($HAPIKey) { return new Forms($HAPIKey); }

	public function keywords($HAPIKey) { return new Keywords($HAPIKey);	}

	public function leadNurturing($HAPIKey) { return new LeadNurturing($HAPIKey); }

	public function leads($HAPIKey) { return new Leads($HAPIKey); }

	public function lists($HAPIKey) { return new Lists($HAPIKey); }

	public function marketPlace($HAPIKey) { return new MarketPlace($HAPIKey); }

	public function properties($HAPIKey) { return new Properties($HAPIKey);	}

	public function settings($HAPIKey) { return new Settings($HAPIKey); }

	public function socialMedia($HAPIKey) { return new SocialMedia($HAPIKey); }

	public function workflows($HAPIKey) { return new WorkFlows($HAPIKey); }
}