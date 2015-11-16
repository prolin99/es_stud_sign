<?php
/*-----------引入檔案區--------------*/
include_once "header.php";
//include_once "function.php";

if ($_GET['class_sit_id']) {

		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "   where class_id = '{$_GET['class_id']}'  and class_sit_num='{$_GET['class_sit_id']}'   " ;

		$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error());
		while($row=$xoopsDB->fetchArray($result)){
			 $data= $row ;
		}

		if ($data) {
            if ($_SESSION['bootstrap'] == '3')
                $show_data = '<span class="label label-danger del"><span class="glyphicon glyphicon-remove"></spam>'.$data['name']. '</span>';
            else
			    			$show_data = '<span class="label del"><i class="icon-remove"></i>'.$data['name']. '</span>';
			$hide_data =  'name:' .$data['name'] .',';
			$field_get= preg_split("/,/" ,$_GET['fi'] ) ;
			$json_array['name'] = $data['name'] ;
			foreach ($field_get as $k =>$v ) {
				//有欄位資料
				if ($data[$v]) {
					$show_data .= '<span class="label label-default">'.$data[$v] . '</span>';
					$hide_data .=  "$v:" .$data[$v] .',';
					//$json_array[$v] = $data[$v] ;
				}
			}
			list($tid_n,$tid)=  preg_split("/_/" ,$_GET['tid'] ) ;
			//最後要呈現的 html
			$json_array['html']  =  "$show_data<input type='hidden' name='get_data[$tid]'  id='get_data_$tid' value='$hide_data'  > " ;
			echo json_encode($json_array,JSON_FORCE_OBJECT);
		}
 /*
 	$json_array= get_student_data_array($_GET['class_sit_id'] , $_GET['class_sit_id'] ,$_GET['tid'] , $_GET['fi']) ;
 	echo json_encode($json_array,JSON_FORCE_OBJECT);
 	*/
}
