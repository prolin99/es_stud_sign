<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-07-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once 'header_admin.php';
//樣版
$xoopsOption['template_main'] = 'esss_adm_alllist_tpl.html';
include_once 'header.php';

/*-----------function區--------------*/
//取得參數


/*-----------執行動作判斷區----------*/

//各班報名情形
$data = get_all_sign_list($_GET['id']);

/*-----------秀出結果區--------------*/

$xoopsTpl->assign('data', $data);

include_once 'footer.php';
