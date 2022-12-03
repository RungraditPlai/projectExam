<?php
class Itemmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
        date_default_timezone_set("Asia/Bangkok");
    }
    public function checkStock($id)
    {
        $jsonObject = file_get_contents('stock.json');
        $data = json_decode($jsonObject, true);

        if (empty($data)) {
            return 0;
        } else {
            foreach ($data as $key => $row) {
                if ($row['itemId'] === $id) {
                    return isset($data[$key]['stock']) ? $data[$key]['stock'] : 0;
                }
            }
            return 0;
        }
    }
    public function insertItems($data)
    {
        $tempArray = [];
        $inp = file_get_contents('logItems.json');
        if (!empty($inp)) {
            $tempArray = json_decode($inp, true);
            array_push($tempArray, $data);
            $jsonData = json_encode($tempArray);
            $this->deletedStock($data['itemId']);
            file_put_contents('logItems.json', $jsonData);
        } else {
            $jsonData = json_encode([$data]);
            $this->deletedStock($data['itemId']);
            file_put_contents('logItems.json', $jsonData);
        }
        return 1;
    }
    public function randomItems($rate)
    {
        $max = 1 / $rate; // 100
        if (mt_rand(0, $max) === 0) {
            return true;
        } else {
            return false;
        }
    }
    private function deletedStock($id)
    {
        $hasItems = false;
        $jsonObject = file_get_contents('stock.json');
        $data = json_decode($jsonObject, true);

        if (empty($data)) {
            $arr = [
                'itemId' => $id,
                'stock' => 1,
            ];
            $jsonData = json_encode([$arr]);
            file_put_contents('stock.json', $jsonData);
        } else {
            foreach ($data as $key => $row) {
                if ($row['itemId'] === $id) {
                    $data[$key]['stock'] += 1;
                    $hasItems = true;
                }
            }
            if ($hasItems == false) {
                $arr = [
                    'itemId' => $id,
                    'stock' => 1,
                ];
                array_push($data, $arr);
                $jsonData = json_encode($data);
                file_put_contents('stock.json', $jsonData);
            } else {
                $jsonData = json_encode($data);
                file_put_contents('stock.json', $jsonData);
            }
        }
        return true;
    }
}
