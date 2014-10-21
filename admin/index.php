<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-07-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";
//樣版
$xoopsOption['template_main'] = "esss_index_adm_tpl.html";
include_once "header.php";
 

/*-----------function區--------------*/
//取得參數


 
/*-----------執行動作判斷區----------*/
if (in_array(1,$xoopsUser->groups()))   {
	//系統管理員才有權限
	$system_admin= 1 ;
	
	//刪除
	if ($_GET['del_id'] )  	
		delete_sign_kind($_GET['del_id']) ;
		
	//清空	
	if  ($_GET['clear_id'] ) 
		clear_sign_kind($_GET['clear_id']) ;
	
}
 
//取得中文班名
$data['class_list_c'] = es_class_name_list_c()  ;


//取得最近的期別---------------------------------------------------------------------------------------------------------------------
$data['kind'] = get_sign_kind(0, 'admin') ;
foreach ($data['kind']  as  $id =>$kind) {
	$data['input_sum'][$id] = get_all_sign_list($id)  ;
}
 
//取得已報名的班級數
$data['class_sum'] = sum_sign_data( );
		


/*-----------秀出結果區--------------*/

$xoopsTpl->assign( "data" , $data ) ; 
$xoopsTpl->assign( "system_admin" , $system_admin ) ; 

 
include_once 'footer.php';
?>