<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);

$deviceToken = SpyderText::Authentication()->createDeviceToken();

//store on disk, or in the database for usage for all other API calls
file_put_contents('./.deviceToken', $deviceToken['device_token']);

var_dump($deviceToken);