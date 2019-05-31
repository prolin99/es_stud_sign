<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//include_once "header_admin.php";
//樣版
$xoopsOption['template_main'] = 'esss_index_add_tpl.html';
include_once 'header.php';
include_once '../function.php';

/*-----------function區--------------*/
//取得參數


/*-----------執行動作判斷區----------*/
//新建一期
if ($_POST['ADD']) {
    $myts = &MyTextSanitizer::getInstance();
    $title = trim($myts->addSlashes($_POST['doc_title']));
    $doc = trim($myts->addSlashes($_POST['txtDoc']));
    $beg_date = $_POST['beg_date'];
    $end_date = $_POST['end_date'];
    foreach ($_POST['grade'] as $k => $v) {
        $input_classY .= $k.',';
    }
    $stud_get = $_POST['txtGet'];
    $stud_get_more = $_POST['txtGetMore'];
    foreach ($_POST['stud'] as $k => $v) {
        $get_data_item .= $v.',';
    }

    foreach ($_POST['txtItemName'] as $k => $v) {
        if ($v) {
            //有欄名
            //$input_data_item .= $_POST['txtItem'][$k].'__'.$v.'__'.$_POST['selI_Mode'][$k].'__'.$_POST['txtI_Width'][$k].'__'.$_POST['txtI_def'][$k].'##';
            $input_data_item .= 'F'.($k+1).'__'.$v.'__'.$_POST['selI_Mode'][$k].'__'.$_POST['txtI_Width'][$k].'__'.$_POST['txtI_def'][$k].'##';
        }
    }

    $uid = $xoopsUser->uid();
    //$creater = $xoopsUser->getVar('name') ;
    if ($_POST['okind_id']) {
        $sql = ' UPDATE  '.$xoopsDB->prefix('sign_kind')."  SET  title ='$title' ,  doc = '$doc'  ,
 			beg_date = '$beg_date' , end_date= '$end_date' , input_classY= '$input_classY'  ,stud_get = '$stud_get'  ,
 			stud_get_more ='$stud_get_more' ,get_data_item ='$get_data_item'  , input_data_item  ='$input_data_item'
 			where id = '{$_POST['okind_id']}'  ";
    } else {
        $sql = ' insert into  '.$xoopsDB->prefix('sign_kind')."  ( title ,  doc ,beg_date , end_date , input_classY  ,stud_get ,stud_get_more ,get_data_item  , input_data_item ,admin )
			values ( '$title' , '$doc' ,  '$beg_date' , '$end_date' , '$input_classY' , '$stud_get' ,'$stud_get_more' , '$get_data_item' , '$input_data_item'  , '$uid'  ) ";
    }

    $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    redirect_header('main.php', 3, '新增一筆報名表....');
}

if ($_POST['templ']) {
    //複製套用舊表格
    $sql = '  SELECT  *   FROM '.$xoopsDB->prefix('sign_kind')."  where id = '{$_POST['old_templ']}'    ";
    $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    $row = $xoopsDB->fetchArray($result);

    //取得舊資料
    $myts = &MyTextSanitizer::getInstance();
    $title = $myts->addSlashes($_POST['doc_title']);
    $doc = $myts->addSlashes($row['doc']);
    $beg_date = $_POST['beg_date'];
    $end_date = $_POST['end_date'];

    $input_classY = $row['input_classY'];
    $stud_get = $row['stud_get'];
    $stud_get_more = $row['stud_get_more'];

    $input_data_item = $row['input_data_item'];

    //$creater = $xoopsUser->getVar('name') ;
    $uid = $xoopsUser->uid();
    $sql = ' insert into  '.$xoopsDB->prefix('sign_kind')."  ( title ,  doc ,beg_date , end_date , input_classY  ,stud_get ,stud_get_more ,get_data_item  , input_data_item ,admin )
			values ( '$title' , '$doc' ,  '$beg_date' , '$end_date' , '$input_classY' , '$stud_get' ,'$stud_get_more' , '$get_data_item' , '$input_data_item'  , '$uid'  ) ";
    $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    $new_kind_id = $xoopsDB->getInsertId();
    redirect_header("add_kind.php?do=edit&id=$new_kind_id", 3, '複製一筆報名表....');
}

//刪除這個報名
if ($_POST['btn_del'] == 'del') {
    delete_sign_kind($_POST['okind_id']);
    redirect_header('main.php', 3, '刪除一筆報名表....');
}

//清空報名資料
if ($_POST['btn_clear'] == 'clear') {
    clear_sign_kind($_POST['okind_id']);
    redirect_header('main.php', 3, '清空報名表....');
}

if ($_GET['do'] == 'edit' and $_GET['id']) {
    //要編修表單
    $data['edit_kind'] = get_sign_kind($_GET['id']+0);
    //檢查是否為擁用者，或系統管理員
    $uid = $xoopsUser->uid();

    if (($data['edit_kind'][$_GET['id']]['uid'] != $uid) and  !in_array(1, $xoopsUser->groups())) {
        redirect_header('main.php', 3, '沒有權限修這張報名表....');
    }
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------
//取得最近的期別選單(提供套用)
$data['kind'] = get_sign_kind_item();

//取得學生年級
$data['grade'] = get_class_grade_list();

$data['beg_date'] = date('Y-m-d');
$data['end_date'] = date('Y-m-d', strtotime('+10 days'));
/*-----------秀出結果區--------------*/

$xoopsTpl->assign('data', $data);
$xoopsTpl->assign('DEF_SET', $DEF_SET);

include_once 'footer.php';
