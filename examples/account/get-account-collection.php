<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
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