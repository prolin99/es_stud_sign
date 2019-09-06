<?php
use XoopsModules\Es_stud_sign\Update;
use XoopsModules\Tadtools\Utility;

function xoops_module_update_es_stud_sign(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if( ! Update::chk_manger() ){
        Update::go_manger();
     }
    return true;
}


?>
