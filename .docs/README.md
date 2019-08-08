# Application

To be used for searching of property owners.

You must have your dedicated CUZK credentials `username` and `password` in order to access the API.
When using the API you are charged for performed requests.

## Content

- [KN- list vlastnictví](#listVlastnictvi)

Integrations:
- [Nette](#Nette)

---

## listVlastnictvi

TODO

### Usage

```php
use AsisTeam\CUZK\Client\LVClientFactory;

$client = (new CiselnikClientFactory('WSTEST', 'WSHESLO', true)->create();
$countries = $client->listCountries();
```

## Nette

You can setup package as Nette compiler extension using neon config
Extension will create all client factories as services

### Usage

```neon
extensions:
	cuzk: AsisTeam\CUZK\DI\CUZKExtension
	
cuzk:
	user: username
	pass: password
	test: true

```
