# SpyderText PHP SDK
The SpyderText PHP Sdk is currently in Beta, and only a few of the SDKs have been built out.
This library will continually be updated as we add support for the additional APIs SpyderText offers.


## Getting Started
With composer simply do a:
```
composer require spydertext/php-sdk "dev-master"
```

Full documentation can be found: https://api.spydertext.com/docs/getting-started

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
Examples are locatd in the examples/account directory, credentials should be placed in the examples/common.php

### Get Account Collection
```php
use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
SpyderText::setDeviceToken(DEVICE_TOKEN);

$collection = SpyderText::Account()->collection([]);

/*
test searching by query
$collection = SpyderText::Account()->collection([
    'q' => 'test'
]);
*/

//will automatically continue looping through and doing API calls for additional pages until it reaches the end
foreach($collection as $account)
{
    echo $account['id'] . "\n";
    echo $account['name'] . "\n\n";
}
```

### Get Account
```php
use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
SpyderText::setDeviceToken(DEVICE_TOKEN);

//get account by ID
$account = SpyderText::Account()->get(4);
var_dump($account);
```

### Save Account
```php
use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

$account = SpyderText::Account()->create([
    'name' => 'Jane Doe',
    'email' => 'jane@example.com',
    'mobile_phone' => '15551231234'
]);
```

### Delete Account
```php
use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

//delete account by ID
$result = SpyderText::Account()->delete(4);
if($result && $result['success']) {
    echo "Successfully deleted account!\n";
}
```

## Program SDK
Examples are located in the examples/program directory, credentials should be placed in the examples/common.php

### Get Program Collection
```php
SpyderText::setApiKey(API_KEY);
SpyderText::setDeviceToken(DEVICE_TOKEN);

$collection = SpyderText::Program()->collection([]);

//will automatically continue looping through and doing API calls for additional pages until it reaches the end
foreach($collection as $program)
{
    echo $program['id'] . "\n";
    echo $program['name'] . "\n\n";
}
```

### Add Participant
```php
use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
SpyderText::setDeviceToken(DEVICE_TOKEN);

$programId = 1;
$accountId = 1;

$result = SpyderText::Program()->addParticipant($programId, $accountId);

if(!$result || !$result['success']) {
    echo "Failed to add participant\n";
    exit;
}

echo "Successfully added participant to program\n";
```