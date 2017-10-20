# SpyderText PHP SDK
The SpyderText PHP Sdk is currently in Beta, and only a few of the SDKs have been built out.
This library will continually be updated as we add support for the additional APIs SpyderText offers.


## Getting Started
With composer simply do a:
```
composer require spydertext/php-sdk "dev-master"
```


## Authentication
You will need to generate a Device Token using the SDK that all other API calls will use. This token should be saved in a database, an environment variable, or placed with your other secrets.
```php
use SpyderText\SpyderText;

SpyderText::setApiKey("YOUR_API_KEY_HERE");

$deviceToken = SpyderText::Authentication()->createDeviceToken();
//store on disk, or in the database for usage for all other API calls
file_put_contents('./.deviceToken', $deviceToken['device_id']);

echo $deviceToken;
```

## Account SDK
Full documentation can be found: https://api.spydertext.com/docs/getting-started

Examples are locatd in the examples/account directory, credentials should be placed in the examples/common.php