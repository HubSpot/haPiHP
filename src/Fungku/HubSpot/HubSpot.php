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
	
	public function blog() { return new Blog();	}

	public function contacts() { return new Contacts();	}

	public function forms() { return new Forms(); }

	public function keywords() { return new Keywords();	}

	public function leadNurturing() { return new LeadNurturing(); }

	public function leads() { return new Leads(); }

	public function lists() { return new Lists(); }

	public function marketPlace() { return new MarketPlace(); }

	public function properties() { return new Properties();	}

	public function settings() { return new Settings(); }

	public function socialMedia() { return new SocialMedia(); }

	public function workflows() { return new WorkFlows(); }
}