<?php
namespace SpyderText;

use SpyderText\SpyderText;
use SpyderText\Base\Component\Request;
use SpyderText\Base\Exception\{
    BaseException,
    InvalidApiCredentialsException
};

class BaseSDK
{
    protected $url = 'www.spydertext.com';

    protected $lastRequest;

    public function next(string $nextUrl)
    {
        return $this->_call('GET', $nextUrl);
    }

    protected function getLastRequest()
    {
        return $this->lastRequest;
    }

    protected function _get(string $url, $params = [])
    {
        return $this->_call('GET', $this->buildUrl($url, $params));
    }
    
    protected function _post(string $url, $postFields = [])
    {
        return $this->_call('POST', $this->buildUrl($url, $postFields, false), $postFields);
    }

    protected function _delete(string $url, $params = [])
    {
        return $this->_call('DELETE', $this->buildUrl($url, $params));
    }

    protected function _call($httpMethod, $url, $postFields = [])
    {
        $this->lastRequest = new Request();
        $this->lastRequest
            ->setHttpMethod($httpMethod)
            ->setUrl($url)
            ->setPostFields($postFields)
        ;

        SpyderText::signRequest($this->lastRequest);

        $this->lastRequest->send();

        $this->lastMethodCalled = $url;

        if(SpyderText::getDebug()) {
            $this->logLastRequest($this->lastRequest);
        }

        $response = json_decode($this->lastRequest->getResult(), true);

        if(!$this->lastRequest->getInfo()['http_code'] || $this->lastRequest->getInfo()['http_code'] < 200 || $this->lastRequest->getInfo()['http_code'] >= 300) {

            if($response && $response['error']) {
                switch($response['error']) {
                    case 'Invalid API Call':
                        throw new InvalidApiCredentialsException("Invalid API Credentials");
                    default:
                        throw new BaseException($response['error']);
                }
            }

            return false;
        }

        
        if(!$response) {
            return false;
        }

        return $response;
    }

    protected function buildUrl($method, &$params = [], $addToQuery = true) : string
    {
        //replace variables inside of the method 
        foreach($params as $key => $value) {
            $safeValue = is_array($value) ? implode(',', $value) : $value;

            $count = 0;
            $method = str_replace(sprintf('{%s}', $key), $safeValue, $method, $count);
            
            if($count) {
                unset($params[$key]);
            }
        }

        $scheme = 'https';
        if($addToQuery) {
            $queryStr = count($params) > 0 ? '?' . http_build_query($params) : '';
        } else {
            $queryStr = '';
        }


        return sprintf("%s://%s%s%s", $scheme, $this->url, $method, $queryStr);
    }

    protected function logLastRequest(Request $request)
    {
        $message = sprintf("%s\n%s::%s\nResult:\n%s\nInfo:\n%s\n\n", 
            (new \DateTime)->format('Y-m-d H:i:s'), 
            static::class, 
            $this->lastMethodCalled, 
            var_export($this->lastRequest->getResult(), true), 
            var_export($this->lastRequest->getInfo(), true)
        );
        
        SpyderText::Log($message);
    }
}