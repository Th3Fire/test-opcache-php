<?php
// แบบไม่กระจายงาน
$time = $_GET['time'];

if($_GET['cmd'] == "op-dis"){
	$part=$_REQUEST['part'];
	$zstart_time=time(); 
	$diff=0;
	for($n=1;$diff<$time;$n++){
		$x=rand(500, 15000)^5;
	$fact1 = $x*floor(log($x,10)) ; // 5 * 4 * 3 * 2 * 1
	`echo "$n" >> /tmp/t4_d_$part.txt`;  
	$zend_time=time(); 
	$diff=$zend_time-$zstart_time;
}
$n = $n - 1 ;
// อ่านไฟล์ t1 ไม่เปิด opcache
$myfile = file_put_contents('logs/t4_d.txt', "{$n}\n",FILE_APPEND);

}else if($_GET['cmd'] == "op-en"){
	$part=$_REQUEST['part'];
	$zstart_time=time(); 
	$diff=0;
	for($n=1;$diff<$time;$n++){
		$x=rand(500, 15000)^5;
	$fact1 = $x*floor(log($x,10)) ; // 5 * 4 * 3 * 2 * 1
	`echo "$n" >> /tmp/t4_e_$part.txt`;  
	$zend_time=time(); 
	$diff=$zend_time-$zstart_time;
}
$n = $n - 1 ;
// อ่านไฟล์ t1 ไม่เปิด opcache
$myfile = file_put_contents('logs/t4_e.txt', "{$n}\n",FILE_APPEND);

}

?>
