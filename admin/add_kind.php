<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";
//樣版
$xoopsOption['template_main'] = "esss_index_add_tpl.html";
include_once "header.php";
 

/*-----------function區--------------*/
//取得參數


 
/*-----------執行動作判斷區----------*/
//新建一期
if ($_POST['ADD']) {
	$myts =& MyTextSanitizer::getInstance();
	$title= $myts->addSlashes($_POST['doc_title']) ;
	$doc= $myts->addSlashes($_POST['txtDoc']) ;
	$beg_date=$_POST['beg_date'] ;
	$end_date=$_POST['end_date'];
	foreach ($_POST['grade'] as $k =>$v)
	 	$input_classY .= $k .','  ;
	$stud_get=$_POST['txtGet'];	 	
	$stud_get_more=$_POST['txtGetMore'];	 	
	foreach ($_POST['stud'] as $k =>$v)
	 	$get_data_item .= $v .','  ; 
	 
	foreach ($_POST['txtItemName'] as $k =>$v) {
		if ($v) {
			$input_data_item .= $_POST['txtItem'][$k] . '__' .  $v . '__' .  $_POST['selI_Mode'][$k] . '__' .  $_POST['txtI_Width'][$k] . '__' . $_POST['txtI_def'][$k] .'##' ;
		}
	}		
	 	 
	 	
	 	
	 	
	//$uid = $xoopsUser->uid() ;  	
 	$creater = $xoopsUser->getVar('name') ;
	$sql = " insert into  " . $xoopsDB->prefix("sign_kind") . "  ( title ,  doc ,beg_date , end_date , input_classY  ,stud_get ,stud_get_more ,get_data_item  , input_data_item ,admin )
			values ( '$title' , '$doc' ,  '$beg_date' , '$end_date' , '$input_classY' , '$stud_get' ,'$stud_get_more' , '$get_data_item' , '$input_data_item'  , '$creater'  ) " ;
 	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 		
 	redirect_header("index.php",3, '新增一筆報名表....' );

 	

}

if ($_POST['SetDate']) {
	//更改填報截止日期
	$now = $_POST['new_deadline'] ;
	$sql = " update   " . $xoopsDB->prefix("afdb_month") . "  set  deadline =  '$now' where  month_id = '$_POST[oldmonth]' " ;
 	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 		
	
}	


//寫入並計算
if ($_POST['calc'] =='calc') {
	//計算人數
 
	 //取得年級班別設定
	$data=get_month_grade($_POST['oldmonth']) ;
	
	//取得人數
	$stud_count =  get_month_sign_team($_POST['oldmonth']) ;
	
	do_calc($data ,$stud_count , 1 ) ;

	
	
}	

//刪除舊期別資料
if ($_POST['clear_old_data'] =='clear_old_data') {
	//只留下最新的期別
 	clear_data($_POST['oldmonth']) ;
 	
}	

//取得最近的期別---------------------------------------------------------------------------------------------------------------------
$data['kind'] = get_sign_kind_item() ;
 

//取得學生年級
$data['grade']=get_class_grade_list() ;

$data['beg_date']=date('Y-m-d') ;
$data['end_date']=date('Y-m-d' ,strtotime('+10 days') ) ;
/*-----------秀出結果區--------------*/

$xoopsTpl->assign( "data" , $data ) ; 
$xoopsTpl->assign( "DEF_SET" , $DEF_SET ) ; 
 
include_once 'footer.php';
?>