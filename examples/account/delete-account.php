<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

//delete account by ID
$result = SpyderText::Account()->delete(4);
var_dump($result);