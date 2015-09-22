<?php

namespace Foo;

class Curl
{
    // private $handle = null;

    // public function __construct($url) {
    //     $this->handle = curl_init($url);
    // }

    // public function setOption($name, $value) {
    //     curl_setopt($this->handle, $name, $value);
    // }

    // public function execute() {
    //     return curl_exec($this->handle);
    // }

    // public function getInfo($name) {
    //     return curl_getinfo($this->handle, $name);
    // }

    // public function close() {
    //     curl_close($this->handle);
    // }

    public function fetch ($url = "http://www.php.net")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($curl);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        curl_close($curl);

        return $contentType;
    }
}
