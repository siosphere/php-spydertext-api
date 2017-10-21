<?php
require_once('../common.php');

use SpyderText\SpyderText;

SpyderText::setApiKey(API_KEY);
//should already have a device token, if not, see authentication/create-device-token.php 
SpyderText::setDeviceToken(DEVICE_TOKEN);

$programId = 1;
$accountId = 1;

$result = SpyderText::Program()->addParticipant($programId, $accountId);

if(!$result || !$result['success']) {
    echo "Failed to add participant\n";
    exit;
}

echo "Successfully added participant to program\n";