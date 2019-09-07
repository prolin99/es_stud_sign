<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-07-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版
//bootstrap 3 header.php 要換，要 function 引入 tadtools
//include_once "header_admin.php";

$xoopsOption['template_main'] = 'esss_adm_manager_tpl.html';
include_once 'header.php';
include_once '../function.php';
/*-----------function區--------------*/



//取得參數


/*-----------執行動作判斷區----------*/
//匯入更新
if ($_POST['do_key']) {
    import_data() ;
}

//匯入判別
function import_data(){
	if ($_FILES['userdata']['name'] ) {

		$file_up = XOOPS_ROOT_PATH."/uploads/" .$_FILES['userdata']['name'] ;
		copy($_FILES['userdata']['tmp_name'] , $file_up );
		$main="開始匯入" . $file_up .'<br>';

		//副檔名
		$file_array= preg_split('/[.]/', $_FILES['userdata']['name'] ) ;
		$ext= strtoupper(array_pop($file_array)) ;

		if ($ext=='XLSX')
			import_excel($file_up , 2007) ;
		//刪除上傳的檔。
		unlink($file_up)  ;
	}

	return $main;

}

//excel 格式
function import_excel($file_up,$ver=2007) {
    global $xoopsDB,$c_year ,$xoopsTpl ,$message ;



	//清空學資料庫
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("sign_manager")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());



	include_once '../../tadtools/PHPExcel/IOFactory.php';

	$reader = PHPExcel_IOFactory::createReader('Excel2007');

	$PHPExcel = $reader->load( $file_up ); // 檔案名稱
	$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
	$highestRow = $sheet->getHighestRow(); // 取得總列數

	// 一次讀取一列
	for ($row = 2; $row <= $highestRow; $row++) {
		$v=array();
		//讀取一列中的每一格
		for ($col = 0; $col <= 2; $col++) {
			$val =  $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
            if (!get_magic_quotes_runtime()) {
                $v[$col]=trim(addSlashes($val));
            } else {
                $v[$col]= trim($val) ;
            }
		}

		if ($v[0]){
           $sql=  "INSERT INTO " . $xoopsDB->prefix("sign_manager") .
    			           "  (`id`, `class_id`, `user_email`, `user_name` )
    			            VALUES ('0' , '{$v[0]}' , '{$v[1]}' , '{$v[2]}'  )  " ;

			$result = $xoopsDB->query($sql)  or      $message .= "語法錯誤：$sql <br/>" ;
			 //echo $sql ."<br>" ;
			 $update_ok_num ++ ;
		}
	}


}

$sql=  " SELECT * FROM " . $xoopsDB->prefix("sign_manager") . " order by class_id , user_email  "  ;
$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
while($row=$xoopsDB->fetchArray($result)){
	$r= array() ;
	 $r['class_id']= $row['class_id'] ;
	 $r['user_email']= $row['user_email'] ;
	 $r['user_name']= $row['user_name'] ;
	 $data[]=$r ;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('data', $data);
$xoopsTpl->assign('message', $message);

include_once 'footer.php';
