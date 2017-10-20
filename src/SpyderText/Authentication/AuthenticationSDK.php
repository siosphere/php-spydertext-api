<?php
namespace SpyderText\Authentication;

use SpyderText\BaseSDK;
use SpyderText\Base\Exception\BaseException;

class AuthenticationSDK extends BaseSDK
{
    public function createDeviceToken()
    {
        //generate a uniqueID for this device
        $uniqueID = sprintf('ST-%s-%s', uniqid(), gethostname());
        
        return $this->_post('/api/v/1/device/token', [
            'device_id' => $uniqueID,
        ]);
    }
}