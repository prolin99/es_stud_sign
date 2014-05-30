<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //
$i=0 ;
$adminmenu[$i]['title'] = '報名管理';
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]['desc'] = '報名管理' ;
$adminmenu[$i]['icon'] = 'images/admin/home.png' ;

$i++ ;
$adminmenu[$i]['title'] = "新增報名";
$adminmenu[$i]['link'] = "admin/add_kind.php";
$adminmenu[$i]['desc'] = '新增報名';
$adminmenu[$i]['icon'] = 'images/admin/about.png';

$i++ ;
$adminmenu[$i]['title'] = "關於";
$adminmenu[$i]['link'] = "admin/about.php";
$adminmenu[$i]['desc'] = '說明';
$adminmenu[$i]['icon'] = 'images/admin/about.png';

?>