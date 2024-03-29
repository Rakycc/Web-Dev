<?php
namespace app\wxcampus\controller;

use think\Controller;
use think\Db;
use think\Request;


class QueryMySchedule extends Controller
{
	public $stu_number;
	public $user_id;
	public $flag = false;

	protected function getUserId($stu_number){
		$result = Db::table("user_info")->where('work_id', $stu_number)->find();
		return $result['id'];
	}

	protected $field_config = array(
		array('name'=>'日期', 'field'=>'date', 'icon'=>'fa-pencil-square-o'),
		array('name'=>'时间', 'field'=>'time_id', 'icon'=>'fa-check-square-o'),
		array('name'=>'事项', 'field'=>'item_id', 'icon'=>'fa-check-square-o'),
		array('name'=>'地点', 'field'=>'place_id', 'icon'=>'fa-check-square-o'),
		array('name'=>'备注', 'field'=>'note', 'icon'=>'fa-pencil-square-o')
	);

	public function defaultList($number){
		$weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
		$this->user_id = $this->getUserId($number);
		$isInTheWhiteList = Db::table('white_list')->where('user_id', $this->user_id)->where('is_delete', 0)->find();
		if($isInTheWhiteList) $this->flag = true;
		if($isInTheWhiteList){
			//echo $this->user_id;
			$sql = "select * from schedule_info where user_id = ".$this->user_id." and is_delete = 0 order by date";
			$result = Db::query($sql);
			$len = count($result);
			for($x = 0; $x < $len; $x++){
				$my_date = $result[$x]['date'];
				if(date("Y-m-d", $my_date) >= date("Y-m-d", strtotime("last Monday")) && date("Y-m-d", $my_date) <= date("Y-m-d",strtotime("+1 week"))){
					$result['weekday'] = $weekarray[date('w', strtotime($my_date))];
					$time_id = $result[$x]['time_id'];
					$time = Db::table('schedule_time')->where('id', $time_id)->value('name');
					$result[$x]['time'] = $time;

					$place_id = $result[$x]['place_id'];
					$place = Db::table('schedule_place')->where('id', $place_id)->value('name');
					$result[$x]['place'] = $place;

					$item_id = $result[$x]['item_id'];
					$item = Db::table('schedule_item')->where('id', $item_id)->value('name');
					$result[$x]['item'] = $item;
				}
			}
			return $result;
		}else{
			return $isInTheWhiteList;
		}
	}

	public function index()
	{
		$userid = input('param.userid');
    	$wxcode = input('param.wxcode');
    	$number = input('param.number');
    	$this->assign([
    		'userid' => $userid,
    		'wxcode' => $wxcode,
    		'number' => $number,
    	]);

		// $number = Request::instance()->param('number');
		$result = $this->defaultList($number);
		if($this->flag){
			$this->assign('date', date('Y-m-d'));
			$this->assign('user_id', $this->user_id);
			$this->assign('schedule_info', $result);
			$this->assign('fields', $this->field_config);
			return $this->fetch('index');
		}else{
			return $this->error("您不在白名单中，请联系管理员");
		}
	}

	public function getMyScheduleInfo(Request $request)
	{
		$userid = input('param.userid');
    	$wxcode = input('param.wxcode');
    	$number = input('param.number');
    	$this->assign([
    		'userid' => $userid,
    		'wxcode' => $wxcode,
    		'number' => $number,
    	]);
		$starttime = $request->param('starttime');
		$endtime = $request->param('endtime');
		$myUserId = $userid;
		if($starttime == NULL) $starttime = "0000-01-01";
		if($endtime == NULL) $endtime = "9999-12-31";
		$sql = "select * from schedule_info where user_id=".$myUserId." and date(date) between date('".$starttime."') and date('".$endtime."') and is_delete = 0 order by date";
		$result = Db::query($sql);  
		$len = count($result);
		for($x = 0; $x < $len; $x++){
			$time_id = $result[$x]['time_id'];
			$time = Db::table('schedule_time')->where('id', $time_id)->value('name');
			$result[$x]['time'] = $time;

			$place_id = $result[$x]['place_id'];
			$place = Db::table('schedule_place')->where('id', $place_id)->value('name');
			$result[$x]['place'] = $place;

			$item_id = $result[$x]['item_id'];
			$item = Db::table('schedule_item')->where('id', $item_id)->value('name');
			$result[$x]['item'] = $item;
		}
		$this->assign('schedule_info', $result);
		//dump($result);
		return $this->fetch('result');
	}

	public function getMyScheduleInfo_2(Request $request)
	{
		$starttime = $request->param('starttime');
		$endtime = $request->param('endtime');
		$myUserId = $request->param('user_id');
		if($starttime == NULL) $starttime = "0000-01-01";
		if($endtime == NULL) $endtime = "9999-12-31";
		$sql = "select * from schedule_info where user_id=".$myUserId." and date(date) between date('".$starttime."') and date('".$endtime."') and is_delete = 0 order by date";
		$result = Db::query($sql);  
		$len = count($result);
		$weekOfToday = date('W');
		for($x = 0; $x < $len; $x++){

			$time_id = $result[$x]['time_id'];
			$time = Db::table('schedule_time')->where('id', $time_id)->value('name');
			$result[$x]['time'] = $time;

			$place_id = $result[$x]['place_id'];
			$place = Db::table('schedule_place')->where('id', $place_id)->value('name');
			$result[$x]['place'] = $place;

			$item_id = $result[$x]['item_id'];
			$item = Db::table('schedule_item')->where('id', $item_id)->value('name');
			$result[$x]['item'] = $item;
		}
		$this->assign('schedule_info', $result);
		//dump($result);
		return $this->fetch('result');
	}
}

?>