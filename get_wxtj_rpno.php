<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-2-11
 * Time: ����5:10
 */
include_once('../../../wxtj/class/database.class.php');

$url = $_SERVER['HTTP_REFERER'];
$arr = explode('&',$url);
$run_id_arr = explode('=',$arr[1]);
$runId = $run_id_arr[1];


$shiyebuObj = Database::select('ITEM_DATA','flow_run_data','run_id='.$runId.' and ITEM_ID=1');
$shiyebu = $shiyebuObj[0]['ITEM_DATA'];

$lastNo = getLastNo($shiyebu);
$nowNo = getNowNo($lastNo,$shiyebu);
$item = array('ITEM_DATA'=>$nowNo);
$condition = 'RUN_id = '.$runId.' and ITEM_ID = 30';//30�Ǳ��浥�����ڵ����к�
Database::update('flow_run_data',$item,$condition);
createWxflow($nowNo,$runId,$shiyebu);

function getLastNo($shiyebu)
{
    //select max(id) FROM wxtj_wxflow where shiyebu = 'ͷ����ҵ��' GROUP BY shiyebu;
    if($shiyebu == '')
    {
        $shiyebu  = 'ͷ����ҵ��';
    }
    $table = 'wxtj_wxflow';
    $condition = 'shiyebu = \''.$shiyebu.'\' GROUP BY shiyebu';
    $item = 'max(id)';
    $result = Database:: selectOne($item,$table,$condition);
    $item = 'rpno';
    $condition = 'id = '.$result;
    $result = Database::select($item,$table,$condition);

    $result_arr = explode('-',$result[0]['rpno']);

    if($result_arr[2] == date('m')){
        $result = (int)$result_arr['3'];
    }else{
        $result = 0;
    }

    return $result;
}
/*
 * $lastNo�ṩ����
 */
function getNowNo($lastNo,$shiyebu)
{
    $noHead = '';
    if($shiyebu == 'ͷ����ҵ��'){
        $noHead = 'TB';
    }else if($shiyebu == '��ù����ҵ��')
    {
        $noHead = 'QMS';
    }else if($shiyebu == '�Ƽ���ҵ��'){
        $noHead = 'ZJ';
    }
    $noSecond = date('Y').'TF';
    $noThird = date('m');
    $noFourth = sprintf("%03d",$lastNo + 1);
    $result = $noHead . '-'.$noSecond.'-'.$noThird.'-'.$noFourth;
    return $result;
}
function createWxflow($nowNo,$runId,$shiyebu)
{
    $table = 'wxtj_wxflow';
    $value = array();
    $value['run_id'] = $runId;
    $value['shiyebu'] = $shiyebu;
    $value['rpno'] = $nowNo;
    $value['ishetong'] = 0;
    Database:: insert($table,$value);
}