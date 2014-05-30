<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";


/********************* 自訂函數 *********************/
$DEF_SET['export']= array('person_id' =>'身份證','sex'=>'性別','birthday' =>'生日' ,'class_sit_num'=>'座號' ,'parent'=>'監護人') ;
//取得預設值
$DEF_SET['fields']=   $xoopsModuleConfig['es_ss_field_num'] +1 ;



//=================================================================================================
function get_class_list(  ) {
	//取得全校班級列表 
	global  $xoopsDB ;
 
		$sql =  "  SELECT  class_id  FROM " . $xoopsDB->prefix("e_student") . "   group by class_id   " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($row=$xoopsDB->fetchArray($result)){
 
			$data[$row['class_id']]=$row['class_id'] ;
	
		}		
	return $data ;		
	
}

function get_class_grade_list(  ) {
	//取得全校年級列表 
	global  $xoopsDB ;
 		$sql =  "  SELECT  SUBSTR( `class_id` , 1, 1 ) AS grade   FROM " . $xoopsDB->prefix("e_student") . "   group by  SUBSTR( `class_id` , 1, 1 )   " ;
 		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($row=$xoopsDB->fetchArray($result)){
 			$data[$row['grade']]=$row['grade'] ;
	
		}		
	return $data ;		
	
}

function get_class_students( $class_id , $mode='class') {
	//取得該班的學生姓名資料   $mode =class ,grade (全學年) , all (全校)
	global  $xoopsDB ;
	if ($mode =='all')  
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "     ORDER BY class_id,  `class_sit_num`  " ;
	elseif ( $mode=='grade') {
		$grade = substr($class_id,0,1) ;
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "  where class_id like '$grade%'   ORDER BY class_id,  `class_sit_num`  " ;
	}else 
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$class_id'   ORDER BY  `class_sit_num`  " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($stud=$xoopsDB->fetchArray($result)){
 
			$data[$stud['tn_id'] ]=$stud ;
	
		}		
	return $data ;		
	//echo $sql ;
	
}



Function get_class_teacher_list() {
	//取得全部級任名冊
	global  $xoopsDB ;
	$sql =  "  SELECT  t.uid, t.class_id , u.name  FROM " . $xoopsDB->prefix("e_classteacher") .'  t  , ' .   $xoopsDB->prefix("users")  .'  u    ' .  
	               " where t.uid= u.uid    " ;
 
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
	while($data_row=$xoopsDB->fetchArray($result)){
 			$class_id[$data_row['class_id']] = $data_row['name'] ;
	}	
	return $class_id  ;
}	

function get_my_class_id($uid =0   ) {
	//取得$uid 的任教班級
	global  $xoopsDB ,$xoopsUser  ;
	if (!$uid)  
		$uid = $xoopsUser->uid() ;
	$sql =  "  SELECT  class_id  FROM " . $xoopsDB->prefix("e_classteacher") . 
	               " where uid= '$uid'   " ;
 
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
	while($data_row=$xoopsDB->fetchArray($result)){
 			$class_id = $data_row['class_id'] ;
	}	
	return $class_id  ;
}


//=====================================================
function get_sign_kind($id =0 , $mode='action') {
	//取得填報項目
	//預設只出現最近可以填報的項目
	global  $xoopsDB ;
	
	if ($id <>0) 
		$sql =  "  SELECT  *  ,( end_date >=  (NOW() - INTERVAL 1 DAY ) ) as cando  , (datediff(`end_date`,now()) +1)  as d_days FROM " . $xoopsDB->prefix("sign_kind") .  "  where id = '$id'  "  ;
	else 	
		$sql =  "  SELECT  *  ,( end_date >=  (NOW() - INTERVAL 1 DAY ) ) as cando , (datediff(`end_date`,now()) +1)  as d_days   FROM " . $xoopsDB->prefix("sign_kind") .  " order by   end_date DESC  LIMIT 0 , 10 "  ;
		
 
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
	while($row=$xoopsDB->fetchArray($result)){
			//把輸入欄位轉換陣列
	 
			$fi= preg_split("/##/" ,$row['input_data_item']) ;
			//var_dump($row['input_data_item']) ;
			//var_dump($fi) ;
 
			foreach ($fi as $k => $v) {
				//echo  $k  .  $v ;
				if (trim($v)<>'')  
					$fi_list[]= preg_split("/__/" ,$v) ;
			}	
			//var_dump($fi_list) ;
 
			$row['field_input'] = $fi_list ;
 
			//把擷取欄位轉換陣列
			$row['field_get']= preg_split("/,/" ,$row['get_data_item']) ;
			
 			$data[$row['id']] = $row ;
 			
	}	
	return $data  ;	
}	

function get_sign_kind_item( ) {
	//取得填報項目只有代號、名稱
 
	global  $xoopsDB ;
	$sql =  "  SELECT  id, title   FROM " . $xoopsDB->prefix("sign_kind") .  " order by   end_date DESC   "  ;
 
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
	while($row=$xoopsDB->fetchArray($result)){
		
 			$data[$row['id']] = $row['title'] ;
	}	
	return $data  ;	
}	


function get_sign_data($kind_id, $class_id) {
	//取得該項的填報學生，
	//$class_id =all 表示全部，
	global  $xoopsDB ;
	if ( $class_id <>'all')
	   $class_sql = "   and  class_id ='$class_id'   " ;
	$sql =  "  SELECT  *    FROM " . $xoopsDB->prefix("sign_data") .  " where kind ='$kind_id'   $class_sql   order by   class_id,  order_pos    "  ;
 
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
	while($row=$xoopsDB->fetchArray($result)){
 			$data[$row['id']] = $row ;
	}	
	return $data  ;		
	
}	

function delete_sign_kind($kind_id) {
	//清除整份填報

	global  $xoopsDB ;
	$sql =  "  DELETE    FROM " . $xoopsDB->prefix("sign_data") .  " where kind ='$kind_id'   "  ;
 	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
 	
 	
	$sql =  "  DELETE    FROM " . $xoopsDB->prefix("sign_kind") .  " where id ='$kind_id'   "  ;
 	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 
 
}	