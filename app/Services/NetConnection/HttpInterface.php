<?php

namespace App\Services\NetConnection;

interface HttpInterface {

    public function get($query);

    public function post($data);

    public function setUrl($url);

    public function getUrl();

    public function setPath($path);
    public function getPath();

}
