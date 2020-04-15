<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-2-11
 * Time: 上午10:47
 */

//include_once('../../../wxtj/class/database.class.php');
//$arr = explode('&',$_SERVER['HTTP_REFERER']);
$str = 'http://localhost:2000/general/workflow/list/turn/turn_next.php?MENU_FLAG=&RUN_ID=102145&FLOW_ID=169&PRCS_ID=1&FLOW_PRCS=1';
$arr = explode('&',$str);
var_dump($arr);
$run_id_arr = explode('=',$arr[1]);
$flow_id_arr = explode('=',$arr[2]);

echo $runId = $run_id_arr[1];//run_id
echo $flowId = $flow_id_arr[1];
$table = 'hetong';
$value = array('flowid'=>$runId,'rpno'=>$flowId);
//Database::insert($table,$value);
