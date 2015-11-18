<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-05-1
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//

$modversion['name'] = '班級報名';                //模組名稱
$modversion['version'] = '1.0';                //模組版次
$modversion['author'] = 'prolin(prolin@tn.edu.tw)';        //模組作者
$modversion['description'] = '以班級為單位報名';            //模組說明
$modversion['credits'] = 'prolin';                //模組授權者
$modversion['license'] = 'GPL see LICENSE';        //模組版權
$modversion['official'] = 0;                //模組是否為官方發佈1，非官方0
$modversion['image'] = 'images/logo.png';        //模組圖示
$modversion['dirname'] = basename(dirname(__FILE__));        //模組目錄名稱

//---模組狀態資訊---//

$modversion['release_date'] = '2014-06-13';
$modversion['module_website_url'] = 'https://github.com/prolin99/es_stud_sign';
$modversion['module_website_name'] = 'prolin';
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://www.syps.tn.edu.tw';
$modversion['author_website_name'] = 'prolin';
$modversion['min_php'] = 5.2;

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'sign_kind';
$modversion['tables'][2] = 'sign_data';

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---要有指定，才會編譯動作，//
$modversion['templates'] = array();
$i = 1;
$modversion['templates'][$i]['file'] = 'esss_index_tpl.html';
$modversion['templates'][$i]['description'] = 'esss_index_tpl.html';
++$i;
$modversion['templates'][$i]['file'] = 'esss_index_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'esss_index_tpl_b3.html';

++$i;
$modversion['templates'][$i]['file'] = 'esss_index_add_tpl.html';
$modversion['templates'][$i]['description'] = 'esss_index_add_tpl.html';
++$i;
$modversion['templates'][$i]['file'] = 'esss_index_add_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'esss_index_add_tpl_b3.html';

++$i;
$modversion['templates'][$i]['file'] = 'esss_index_adm_tpl.html';
$modversion['templates'][$i]['description'] = 'esss_index_adm_tpl.html';
++$i;
$modversion['templates'][$i]['file'] = 'esss_index_adm_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'esss_index_adm_tpl_b3.html';

 ++$i;
$modversion['templates'][$i]['file'] = ' esss_adm_alllist_tpl.html';
$modversion['templates'][$i]['description'] = ' esss_adm_alllist_tpl.html';
++$i;
$modversion['templates'][$i]['file'] = ' esss_adm_alllist_tpl_b3.html';
$modversion['templates'][$i]['description'] = ' esss_adm_alllist_tpl_b3.html';

$i = 0;
//偏好設定
++$i;
//預設額外欄位數
$modversion['config'][$i]['name'] = 'es_ss_field_num';
$modversion['config'][$i]['title'] = '_MI_ES_SS_CONFIG_T1';
$modversion['config'][$i]['description'] = '_MI_ES_SS_CONFIG_D1';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '4';
