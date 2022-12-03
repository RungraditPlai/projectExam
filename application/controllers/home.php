<?php

use chriskacerguis\RestServer\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class home extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ItemModel', 'item');
    }
    public function index_get()
    {

        $getfile = file_get_contents('items.json');
        $jsonfile['data'] = json_decode($getfile);
        $this->load->view('items', $jsonfile);
    }

    public function random_get()
    {

        // file_put_contents("items.json", '');
        file_put_contents("stock.json", '');
        file_put_contents("logItems.json", '');

        $getfile = file_get_contents('items.json');
        $jsonfile = json_decode($getfile);
        $limit = 100;
        $x = 1;
        if (!empty($jsonfile)) {
            while ($x <=  $limit) {
                foreach ($jsonfile as $row) {
                    $nameItem = $row->name;
                    $gameId = $row->game_item_id;
                    $chance = (float) isset($row->chance) ? $row->chance : 0;
                    $stock = $row->stock;
                    $checkRandom = $this->item->randomItems($chance);
                    if ($checkRandom == true) {
                        $posts = [
                            'itemId' => $gameId,
                            'name' => $nameItem,
                            'holdStock' => 1,
                        ];
                        $holdStock = $this->item->checkStock($gameId);
                        if ($holdStock < $stock) {
                            if ($x <= 100) {
                                $this->item->insertItems($posts);
                            }
                            $x++;
                        }
                    }
                }
            }
        }

        $listItems = file_get_contents('logItems.json');
        $dataItems['data'] = json_decode($listItems, true);

        $this->load->view('itemsList', $dataItems);
    }
}
