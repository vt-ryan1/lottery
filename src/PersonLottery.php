<?php

namespace Victtech\Lottery;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

/**
 * 固定的奖项，随机获取中奖人
 */
class PersonLottery extends BaseLottery
{
    /**
     * @param array $dataSource  数据源
     * @param int $lucks 中奖数量
     * @return mixed
     */
    public function getAward(array $dataSource,int $lucks):array
    {
        $persons =  array();
        shuffle($dataSource);
        for($i = 0 ;$i < count($dataSource) ; $i++){
            //检查是否中过奖，为真，没有中过，可以中奖。
            if(count($persons) < $lucks && $this->checkLucky($dataSource[$i])){
                array_push($persons,$dataSource[$i]);
            }

        }
        return $persons;
    }

    /**
     * 检查某个数据是否已经中过奖
     * @param $data
     * @return bool //返回是否中过奖。 true:没中过奖，false:已经中过奖，不能再中
     */
    private function checkLucky($data):bool
    {
        $file_name = storage_path('/logs/') . 'vt_lucky_person.log';
        $personInfo = null;
        if (file_exists($file_name)) {
            $personInfo = fopen($file_name, 'r+');
        } else {
            $personInfo = fopen($file_name, 'w+');
        }
        $row = fgets($personInfo);
        $flag = false; //标记是否已经有相同的人中奖
        if ($row !== false) {

            $row = json_decode($row, JSON_UNESCAPED_UNICODE);
            foreach ($row as $item) {
//                ksort($item);//按数组建排序
//                ksort($data);

                $itemStr = md5(json_encode($item, JSON_UNESCAPED_UNICODE));
                $dataStr = md5(json_encode($data, JSON_UNESCAPED_UNICODE));
                if ($itemStr == $dataStr) {
                    $flag = true;
                    break;
                }
            }

        } else {
            $row = [];
        }
        //没有相同人中奖,则记录中奖人
        if ($flag == false) {
            array_push($row, $data);
            $row = json_encode($row, JSON_UNESCAPED_UNICODE);
            fseek($personInfo, 0);
            fwrite($personInfo, $row);
            fclose($personInfo);
            return true;
        } else {
            //已经中过奖，不能再中
            return false;
        }


    }
}
