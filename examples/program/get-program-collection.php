<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

$collection = SpyderText::Program()->collection([]);

//will automatically continue looping through and doing API calls for additional pages until it reaches the end
foreach($collection as $program)
{
    echo $program['id'] . "\n";
    echo $program['name'] . "\n\n";
}