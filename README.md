# HubSpot PHP API client

## Example

This is how I use it.

```php
$hapikey = "demo";

$params = array(
	'count' => 5, // defaults to 20
	'property' => 'firstname', // only get the specified properties
	'vidOffset' => '50' // contact offset used for paging
);

// get 5 contacts' firstnames, offset by 50
$contacts = HubSpot::contacts($hapikey)
	->get_all_contacts($params);
```

## haPiHP

### Overview

A PHP client for HubSpot's APIs.  Docs for this client: [https://github.com/HubSpot/haPiHP/wiki/haPiHP](https://github.com/HubSpot/haPiHP/wiki/haPiHP).

General API reference documentation: [http://developers.hubspot.com/docs](http://developers.hubspot.com/docs).

### Contributors

* [adrianmott](https://github.com/adrianmott) (Adrian Mott)
* [chrishoult](https://github.com/chrishoult) (Christopher Hoult)
* [TheRealBenSmith](https://github.com/TheRealBenSmith) (Ben Smith)
* [ajorgensen](https://github.com/ajorgensen) (Andrew Jorgensen)
* [jprado](https://github.com/jprado)
* [thinkclay](https://github.com/thinkclay) (Clayton McIlrath)
