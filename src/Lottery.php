<?php

namespace Victtech\Lottery;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class Lottery
{
    protected $session;
    protected $config;


    public function __construct(SessionManager $session,Repository $config){
        $this->session = $session;
        $this->config = $config;
    }

    public function getAward()
    {
        $award = null;
        $lockFile = storage_path('/logs/').'vt_lottery_lock.log';
        $fp = fopen($lockFile,'w+');
        if(flock($fp,LOCK_EX | LOCK_NB)){ //校验是否有人正在抽奖
            $award = $this->probability(); //抽奖品
            flock($fp,LOCK_UN);
            fclose($fp);
        }
        return $award;
    }

    private function recordAward($award){
        $config = $this->config->get('lottery.awards');
        $file_name = storage_path('/logs/').'vt_award_info.log';
        $awardInfo = null;
        if(file_exists($file_name)){
            $awardInfo = fopen($file_name,'r+');
        }else{
            $awardInfo = fopen($file_name,'w+');
        }

        $row = fgets($awardInfo);
        if($row!==false){
            $recordInfo = json_decode($row,JSON_UNESCAPED_UNICODE);
            foreach($recordInfo as $key=>$item){
                if($award == $key){
                    if($item < $config[$key]['total']){ //如果小于总数，则记录
                        $recordInfo[$key] = $item +1;
                    }else{ //否则奖品置空，不中奖
                        $award = null;
                    }

                }
            }
            $config = $recordInfo;
        }else{ //第一次记录
            foreach($config as $key=>$item){
                if($key == $award ){
                    if($item['total']>0){ //有奖品总数,奖品数加1
                        $config[$key] = 1;
                    }else{ //否则奖品置空，不中奖
                        $award = null;
                    }

                }else{
                    $config[$key] = 0;
                }
            }
        }

        $configStr = json_encode($config,JSON_UNESCAPED_UNICODE);
        fseek($awardInfo,0);
        fwrite($awardInfo,$configStr);
        fclose($awardInfo);
        return $award;
    }



    //按概率计算抽奖
    private function probability(){
        $base =100;
        $awards = $this->config->get('lottery.awards');
        $noBingo = 0;
        $prize_arr = array();
        foreach($awards as $key=>$item){
            $noBingo += $item['probability'];
            $prize = [
                'id'=>$key,
                'prize'=>$key,
                'v'=>$item['probability']
            ];
            array_push($prize_arr,$prize);
        }
        array_push($prize_arr,array('id'=>'未中奖','prize'=>'未中奖','v'=>$base-$noBingo));

        $proArr =[];
        foreach ($prize_arr as $key => $val) {
            $proArr[$val['id']] = $val['v'];
        }
        arsort($proArr); //根据概率重新倒排序

        $result = null;

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        $result = $this->recordAward($result); //记录和校验奖品总数
        return $result;
    }
}
