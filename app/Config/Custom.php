<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Custom extends BaseConfig
{
    public $base_url        = 'http://localhost';
    public $pustaka_url     = 'http://localhost';
    public $secure_base_url = 'http://localhost/pustaka';
    public $server_url      = 'http://localhost/pustaka';
    public $s3_url          = 'https://pustaka-assets.s3.ap-south-1.amazonaws.com';
}