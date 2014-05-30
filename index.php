<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/

$xoopsOption['template_main'] = "esss_index_tpl.html";
include_once "header.php";
include_once XOOPS_ROOT_PATH."/header.php";



/*-----------function區--------------*/
 


 

/*-----------執行動作判斷區----------*/
 if  ( $_GET['id'] ) {
	$id = $_GET['id'] ;
	
 
	//取得報名項目
	$data['kind_in'] = get_sign_kind($id) ;
	//var_dump($data['kind_in']) ;
 	//取得任教班級
	$class_id = get_my_class_id() ;
 

 
	
	if ($isAdmin){
	  	//管理者可以選取多班
		$data['admin'] = true ;
		//取得班級
		if ($_POST['admin_class_id']) 
			$class_id=$_POST['admin_class_id'] ;
		elseif ( !$class_id)
			$class_id= '101' ;

		//班級名稱列表
		$data['class_list']=get_class_list() ;
		//$data['month_data']['cando'] =1 ;
	}	
	
	//判別是否在填報年級
	$grade = substr($class_id,0,1) ;
	if  ( strrchr(  $data['kind']['input_classY']  , $grade) )  
		$date['class_can_fg'] = true ;
	else 
		$date['class_can_fg'] = false ;
		
	//取得現在班級姓名
	$data['class_stud']=get_class_students($class_id) ;
	
	$data['sel_class']  =$class_id ;

 
	//取得已填報資料
	$data['class_input'] =  get_sign_data($id, $class_id) ;
	//
	
}else {	

	 //取得所有報名期別
	$data['kind'] = get_sign_kind() ;
}

 

 
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;

$xoopsTpl->assign( "data" , $data ) ; 
$xoopsTpl->assign( "DEF_SET" , $DEF_SET ) ; 
 
 
 
include_once XOOPS_ROOT_PATH.'/footer.php';

?>