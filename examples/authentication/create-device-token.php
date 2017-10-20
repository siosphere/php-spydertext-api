<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not can call this to get and store a device token

$deviceToken = SpyderText::Authentication()->createDeviceToken();
//store on disk, or in the database for usage for all other API calls
file_put_contents('./.deviceToken', $deviceToken['device_id']);

echo $deviceToken;