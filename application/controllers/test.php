<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function examplePage()
    {
        echo 'this ex page';
        die();
    }
}
