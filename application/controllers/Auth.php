<?php

use chriskacerguis\RestServer\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('jwt');
    }
    public function index_post()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $arr = [
            'email' => $email,
            'password' => $password,
        ];
        $data['token'] = $this->jwt->encode($arr);
        echo json_encode($data);
    }
    public function profile_get()
    {

        $payload = getallheaders();
        $token = $payload['Authorization'];
        $data = $this->jwt->decode($token);

        $email = $data->email;
        $password = $data->password;


        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);
        foreach ($data as $key => $val) {
            if ($data[$key]['name']) {

                if ($data[$key]['email'] === $email && $data[$key]['password'] === $password) {
                    echo json_encode(['email' => $email]);
                }
            }
        }
        echo json_encode(['error' => 'login failed']);
    }
}
