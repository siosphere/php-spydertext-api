<?php
namespace SpyderText\Base\Component;

class Request
{
    protected $url;

    protected $httpMethod;

    protected $headers = [];

    protected $postFields = [];

    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    public function setHttpMethod(string $httpMethod)
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    public function addHeader(string $header)
    {
        $this->headers[] = $header;

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function setPostFields(array $postFields)
    {
        $this->postFields = $postFields;

        return $this;
    }

    public function send()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch($this->httpMethod)
        {
            case 'POST':
                $this->headers = array_merge([
                    'Accept: application/json',
                    'Content-Type: application/json',
                ], $this->headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->postFields));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default:
        }

        if(!empty($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        $this->result = curl_exec($ch);
        $this->info = curl_getinfo($ch);

        curl_close($ch);
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getResult()
    {
        return $this->result;
    }
}