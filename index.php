<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-06-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
use XoopsModules\Tadtools\Utility;
//$xoopsOption['template_main'] = "esss_index_tpl.html";
include_once 'header.php';
$xoopsOption['template_main'] = 'esss_index.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';

 if (!$xoopsUser) {

     redirect_header(XOOPS_URL, 3, '需要登入，才能使用！');
 }



/*-----------function區--------------*/

 if ($_POST['ADD'] == 'add') {
     //新增報名資料

    //要輸入的欄位名
            $fi = preg_split('/##/', $_POST['input_data_item']);

     foreach ($fi as $k => $v) {
         if (trim($v) != '') {
             list($fid, $ff1, $ff2, $ff3, $ff4) = preg_split('/__/', $v);
             $input_field[] = $fid;
         }
     }

     for ($k = 1; $k <= ($_POST['studs_get'] + $_POST['studs_more']); ++$k) {
         //正取、備取人數
        $v = $_POST['num_id'][$k];
        //echo $v . '   .. '  . $k . '   .. '  . $_POST['num_id'][$k] .'<br>';
         if ($v) {
             //如果是座號(未轉換成姓名....等)
            if (is_int($v)) {
                $stud_get_array = get_student_data_array($_POST['now_class'], $v, 'ii_0', $_POST['get_data_item']);
                $v = $stud_get_array['name'];
                $_POST['get_data'][$k] = $stud_get_array['hide_data'];
                //echo  $stud_get_array['hide_data'] ;
            }

             $input = '';
             $update_id = '';
             foreach ($input_field as $ik => $iv) {
                 $fn = 'in_'.$iv;
                 $input .= $iv.'__'.$_POST[$fn][$k].'##';
             }
            //檢查有無存在
            $sql = '	select id from  '.$xoopsDB->prefix('sign_data')." where kind = '{$_POST['now_kind']}'  and class_id = '{$_POST['now_class']}'  and  order_pos = '$k' ";
            $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
             while ($row = $xoopsDB->fetchArray($result)) {
                 $update_id = $row['id'];
             }
             if ($update_id) {
                 $sql = ' UPDATE '.$xoopsDB->prefix('sign_data')."   SET  `stud_name`='$v' , `data_get`='{$_POST['get_data'][$k]}' ,`data_input`='$input' WHERE  id ='$update_id' ";
             } else {
                 //新增
                $sql = '	INSERT INTO  '.$xoopsDB->prefix('sign_data')." (  `kind`, `order_pos`, `stud_name`, `data_get`, `data_input`, `class_id`)
				VALUES ({$_POST['now_kind']},$k,'$v', '{$_POST['get_data'][$k]}'  ,'$input' , '{$_POST['now_class']}'   ) ";
             }
             echo $sql.'<br>'; 

             $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
         } else {
             //移除空白
            $sql = '  DELETE    FROM '.$xoopsDB->prefix('sign_data')." where kind ='{$_POST['now_kind']}'  and class_id = '{$_POST['now_class']}'  and  order_pos = '$k'     ";
             $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
         }
     }
 }

if ($_POST['Submit_emp'] == 'empt') {
    //無學生要報名
    $sql = '	select id from  '.$xoopsDB->prefix('sign_data')." where kind = '{$_POST['now_kind']}'  and class_id = '{$_POST['now_class']}'    ";
    $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    while ($row = $xoopsDB->fetchArray($result)) {
        $update_id = $row['id'];
    }
    if (!$update_id) {
        //無資料才寫入
        $sql = '	INSERT INTO  '.$xoopsDB->prefix('sign_data')." (  `kind`, `order_pos`,  `class_id`)
			VALUES ({$_POST['now_kind']}, '-99' , '{$_POST['now_class']}'   ) ";
        $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    }
}

/*-----------執行動作判斷區----------*/
//取得任教班級
$class_id = get_my_class_id();
//var_dump($class_id) ;
//echo  $xoopsUser->email();


//echo 'clllllll--'  . $class_id ;
 if ($_GET['id']) {
     $id = intval($_GET['id']);

    //取得中文班名
    $data['class_list_c'] = es_class_name_list_c('long');

    //取得報名項目
    $data['kind_in'] = get_sign_kind($id);
    //var_dump($data['kind_in']) ;

    if ($isAdmin) {
        //管理者可以選取多班
        $data['admin'] = true;
        //取得班級
        $data['class_list'] = get_class_list($data['kind_in'][$id]['input_classY']);

        if ($_POST['admin_class_id']) {
            $class_id = $_POST['admin_class_id'];
        } elseif (!$class_id) {
            $class_id = key($data['class_list']);
        }

        $grade = substr($class_id, 0, 1);
        if (!in_array($grade, $data['kind_in'][$id]['grade'])) {
            $class_id = key($data['class_list']);
        }
    } else {

          //判別是否在填報年級
          $grade = substr($class_id, 0, 1);

            if (!$class_id) {
                redirect_header('index.php', 3, '無負責的班級，無法填報');
            }

            if (!in_array($grade, $data['kind_in'][$id]['grade'])) {
                redirect_header('index.php', 3, '貴班無需填報');
            }

    }

    $xoopsTpl->assign('no_bootstrap_v2', $_SESSION['bootstrap'] >= 3);

    //取得現在班級姓名
    $data['class_stud'] = get_class_students($class_id);
    //var_dump($data['class_stud']) ;
    $data['class_sit_num_list'] = get_class_all_sit_id($class_id);

     $data['sel_class'] = $class_id;

    //取得已填報資料
    $data['my_class'] = get_sign_data($id, $class_id);
    //var_dump($data['my_class']) ;
 } else {

     //取得所有報名期別
    $data['kind'] = get_sign_kind(0, 'list', $class_id, $isAdmin);
 }

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', Utility::get_bootstrap());
$xoopsTpl->assign('jquery', Utility::get_jquery(true));

$xoopsTpl->assign('data', $data);
$xoopsTpl->assign('DEF_SET', $DEF_SET);
$xoopsTpl->assign('no_bootstrap_v2', $_SESSION['bootstrap'] >= 3);

include_once XOOPS_ROOT_PATH.'/footer.php';
