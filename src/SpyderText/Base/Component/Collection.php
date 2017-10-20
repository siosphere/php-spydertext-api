<?php
namespace SpyderText\Base\Component;
use SpyderText\BaseSDK;

class Collection implements \Iterator
{
    protected $rows = [];

    protected $nextUrl;

    protected $index;

    protected $sdk;

    public function __construct($collectionData = [], BaseSDK $sdk)
    {
        if(!isset($collectionData['rows'])) {
            throw new \InvalidArgumentException("Invalid API Collection");
        }

        $this->rows = $collectionData['rows'];

        $this->nextUrl = $collectionData['next'];
        $this->sdk = $sdk;
        $this->index = 0;
    }

    public function current()
    {
        return $this->rows[$this->index];
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->index++;
    }

    public function rewind()
    {
        $this->index = 0;
    }

    public function valid()
    {
        if(!isset($this->rows[$this->index]) && $this->nextUrl) {
            //do the next url
            //if successful append the rows
            $result = $this->sdk->next($this->nextUrl);
            if(!$result) {
                return false;
            }
            
            $this->rows = array_merge($this->rows, $result['rows']);
            $this->nextUrl = $result['next'];
            
            return true;
        }

        return isset($this->rows[$this->index]);
    }
}