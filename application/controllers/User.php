<?php

use chriskacerguis\RestServer\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('jwt');
    }
    public function login_get()
    {
        $this->load->view('login');
    }
    public function list_get()
    {


        $getfile = file_get_contents('data.json');
        $jsonfile['data'] = json_decode($getfile, true);


        $page = !isset($_GET['page']) ? 1 : $_GET['page'];
        $limit = !isset($_GET['size']) ? 1 : $_GET['size'];

        $offset = ($page - 1) * $limit; // offset
        $total_items = count($jsonfile['data']); // total items
        $total_pages = ceil($total_items / $limit);
        $final['data']['list'] = array_splice($jsonfile['data'], $offset, $limit); // splice them according to offset and limit
        $final['data']['total'] = $total_items;
        $final['data']['page'] = (int)$page;

        echo json_encode($final);
        // $this->load->view('user', $final);
    }

    public function delete_get()
    {
        $username = isset($_GET['username']) ? $_GET['username'] : null;
        if ($username !== null) {
            $jsonObject = file_get_contents('data.json');
            $data = json_decode($jsonObject, true);
            // // echo '<pre>';
            // // print_r($data);
            // // echo '</pre>';
            // die();
            foreach ($data as $key => $row) {
                if ($row['username'] === $username) {
                    unset($data[$key]);
                }
            }

            $array = array_values($data);

            file_put_contents('data.json', []);
            file_put_contents('data.json', json_encode($array));
        }
        echo json_encode(['message' => 'success']);
        // redirect('http://localhost/example/user/index');
        // header("location: http://localhost/example/user/index");
        // exit(0);
    }
    // public function edit_get()
    // {
    //     $username = isset($_GET['username']) ? $_GET['username'] : null;

    //     $jsonObject = file_get_contents('data.json');
    //     $data = json_decode($jsonObject, true);
    //     // // echo '<pre>';
    //     // // print_r($data);
    //     // // echo '</pre>';
    //     // die();
    //     foreach ($data as $key => $row) {
    //         if ($row['username'] === $username) {
    //             $arr['data'] = $data[$key];
    //             $arr['data']['temp'] = $username;
    //             // return $this->load->view('edituser', $arr);
    //             // die();
    //         }
    //     }

    //     $array = array_values($data);

    //     // file_put_contents('data.json', []);
    //     // file_put_contents('data.json', json_encode($array));
    //     echo json_encode(['message' => 'success']);
    //     // // redirect('http://localhost/example/user/index');
    //     // header("location: http://localhost/example/user/index");
    //     // exit(0);
    // }
    public function edit_post()
    {




        $input['name'] = isset($_POST['fname']) ? $_POST['fname'] : null;
        $input['phone'] = isset($_POST['phone']) ? $_POST['phone'] : null;
        $input['email'] = isset($_POST['email']) ? $_POST['email'] : null;
        $input['password'] = isset($_POST['password']) ? $_POST['password'] : null;
        $user = isset($_POST['usernameAtChange']) ? $_POST['usernameAtChange'] : null;
        $input['company'] = isset($_POST['company']) ? $_POST['company'] : null;
        $input['nationality'] = isset($_POST['nationality']) ? $_POST['nationality'] : null;


        foreach ($input as $key => $val) {
            if ($input[$key] === null) {
                echo json_encode(['error' => 'error ' . $key]);
                die();
            }
        }

        $check = $this->checkUserEdit($input);
        if ($check != 1) {
            echo json_encode(['error' => 'duplicate ' . $check]);
            die();
        }

        $uppercase = preg_match('@[A-Z]@', $input['password']);
        $lowercase = preg_match('@[a-z]@', $input['password']);
        $number    = preg_match('@[0-9]@', $input['password']);
        $specialChars = preg_match('@[^\w]@', $input['password']);

        if (!$uppercase || !$lowercase || !$number  || strlen($input['password']) < 8) {
            echo 'bad request';
        }

        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);
        foreach ($data as $key => $row) {;
            if ($row['username'] === $user) {
                $data[$key] = $input;
                $data[$key]['username'] = $user;

                file_put_contents('data.json', []);

                file_put_contents('data.json', json_encode($data));
                echo json_encode(['message' => 'success']);
                die();
            }
        }
    }
    public function search_get()
    {
        $search = 0;
        $q = isset($_GET['q']) ? $_GET['q'] : null;
        $result = [];
        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);
        foreach ($data as $key => $row) {

            if ($data[$key]['name'] === $q) {
                $search = 1;
            } else if ($data[$key]['phone'] === $q) {
                $search = 1;
            } elseif ($data[$key]['email'] === $q) {
                $search = 1;
            } else if ($data[$key]['username'] === $q) {
                $search = 1;
            } elseif ($data[$key]['company'] === $q) {
                $search = 1;
            } elseif ($data[$key]['nationality'] === $q) {
                $search = 1;
            }
            if ($search == 1) {
                array_push($result, $data[$key]);
            }
            $search = 0;
        }
        array_values($result);
        if (empty($result)) {
            echo json_encode(['message' => 'not found']);
        } else {
            echo json_encode(['data' => $result]);
        }
    }
    public function add_post()
    {


        $input['name'] = isset($_POST['fname']) ? $_POST['fname'] : null;
        $input['phone'] = isset($_POST['phone']) ? $_POST['phone'] : null;
        $input['email'] = isset($_POST['email']) ? $_POST['email'] : null;
        $input['password'] = isset($_POST['password']) ? $_POST['password'] : null;
        $input['username'] = isset($_POST['username']) ? $_POST['username'] : null;
        $input['company'] = isset($_POST['company']) ? $_POST['company'] : null;
        $input['nationality'] = isset($_POST['nationality']) ? $_POST['nationality'] : null;

        $check = $this->checkUser($input);
        if ($check != 1) {
            echo json_encode(['error' => 'duplicate ' . $check]);
            die();
        }
        foreach ($input as $key => $val) {
            if ($input[$key] === null || $input[$key] == '') {
                echo json_encode(['error' => 'error']);
                die();
            }
        }


        $uppercase = preg_match('@[A-Z]@', $input['password']);
        $lowercase = preg_match('@[a-z]@', $input['password']);
        $number    = preg_match('@[0-9]@', $input['password']);
        $specialChars = preg_match('@[^\w]@', $input['password']);

        if (!$uppercase || !$lowercase || !$number  || strlen($input['password']) < 8) {
            echo json_encode(['error' => 'password']);
            die();
        }

        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);

        array_push($data, $input);
 

        $array = array_values($data);

        file_put_contents('data.json', []);
        file_put_contents('data.json', json_encode($array));
        echo json_encode(['message' => 'success']);
        // // redirect('http://localhost/example/user/index');
        // header("location: http://localhost/example/user/index");
        // exit(0);
    }
    public function checkUser($input)
    {


        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);
        foreach ($data as $key => $val) {
            if ($data[$key]['name']) {
                if ($data[$key]['name'] === $input['name']) {
                    return 'name';
                }
                if ($data[$key]['phone'] === $input['phone']) {
                    return 'phone';
                }
                if ($data[$key]['email'] === $input['email']) {
                    return 'email';
                }
                if ($data[$key]['username'] === $input['username']) {
                    return 'username';
                }
                // if ($data[$key]['company'] === $input['company']) {
                //     return 'company';
                // }
                // if ($data[$key]['nationality'] === $input['nationality']) {
                //     return 'nationality';
                // }
            }
        }
        return 1;
    }
    public function checkUserEdit($input)
    {

        $tempname = 0;
        $tempphone = 0;
        $tempemail = 0;
        $tempusername = 0;
        $jsonObject = file_get_contents('data.json');
        $data = json_decode($jsonObject, true);
        foreach ($data as $key => $val) {
            if ($data[$key]['name']) {
                if ($data[$key]['name'] === $input['name']) {

                    $tempname += 1;
                }
                if ($data[$key]['phone'] === $input['phone']) {
                    $tempphone += 1;
                }
                if ($data[$key]['email'] === $input['email']) {
                    $tempemail += 1;
                }
                // if ($data[$key]['username'] === $input['username']) {
                //     $tempusername += 1;
                // }
            }
        }

        if ($tempname >= 2) {
            return 'name';
        }
        if ($tempphone >= 2) {
            return 'phone';
        }
        if ($tempemail >= 2) {
            return 'email';
        }
        // if ($tempusername >= 2) {
        //     return 'username';
        // }
        return 1;
    }
}
