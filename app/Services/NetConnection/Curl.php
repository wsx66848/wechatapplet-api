<?php

namespace App\Services\NetConnection;

class Curl implements HttpInterface {

    protected $url;
    protected $path;
    protected $options = [];

    public function __construct($url=null) {
        $this->url = $url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    protected function setOptions($option, $value = null) {
        $options = $this->options;
        if(! is_array($option)) {
            $option = [$option => $value];
        }
        foreach($option as $opt => $v) {
            $options[$opt] = $v;
        }
        $this->options = $options;
    }

    public function get($query) {
        $this->setOptions(CURLOPT_HTTPGET, true);
        unset($this->options[CURLOPT_POST]);
        unset($this->options[CURLOPT_POSTFIELDS]);
        return $this->query(http_build_query($query));
    }

    public function post($data) {
        $this->setOptions([
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ]);
        unset($options[CURLOPT_HTTPGET]);
        $query = $data['query'] ?? null;
        return $this->query($query);
    }

    protected function query($query = null) {
        $url = $this->url . $this->path;
        if (!empty($query)) {
            $url = $url . '?' . $query;
        }
        $curl = curl_init($url);
        $default_options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 60,
        ];
        $options = $this->options + $default_options;
        curl_setopt_array($options);
        $response = curl_exec($url);
        curl_close($curl);
        return $response;

    }





}
