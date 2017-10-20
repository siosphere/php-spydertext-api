<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

$account = SpyderText::Account()->create([
    'name' => 'Jane Doe',
    'email' => 'jane@example.com',
    'mobile_phone' => '15551231234'
]);