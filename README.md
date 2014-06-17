# HubSpot PHP API client

## Example


```php
$hapikey = "demo";

$params = array(
	'count' => 5, // defaults to 20
	'property' => 'firstname', // only get the specified properties
	'vidOffset' => '50' // contact offset used for paging
);

$hubspot = new Fungku\HubSpot\HubSpot($hapikey);

// get 5 contacts' firstnames, offset by 50
$contacts = $hubspot->contacts()
	->get_all_contacts($params);
```

Note: The Hubspot class checks for `HUBSPOT_APIKEY` environment variable if you don't include one during instantiation.


### haPiHP

#### Overview

A PHP client for HubSpot's APIs.  Docs for this client: [https://github.com/HubSpot/haPiHP/wiki/haPiHP](https://github.com/HubSpot/haPiHP/wiki/haPiHP).

General API reference documentation: [http://developers.hubspot.com/docs](http://developers.hubspot.com/docs).

### Contributors

* [adrianmott](https://github.com/adrianmott) (Adrian Mott)
* [chrishoult](https://github.com/chrishoult) (Christopher Hoult)
* [TheRealBenSmith](https://github.com/TheRealBenSmith) (Ben Smith)
* [ajorgensen](https://github.com/ajorgensen) (Andrew Jorgensen)
* [jprado](https://github.com/jprado)
* [thinkclay](https://github.com/thinkclay) (Clayton McIlrath)
