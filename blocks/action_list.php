<?php
use XoopsModules\Tadtools\Utility;
//use XoopsModules\Es_stud_sign\Es_stud_sign_actions;

// 可報名活動一覽
function action_list($options)
{

    global  $xoopsDB;
    $sql = '  SELECT  id, title   FROM '.$xoopsDB->prefix('sign_kind').'  where end_date >= Now() order by   id  DESC   ';

    $result = $xoopsDB->query($sql) or die($sql.'<br>'.$xoopsDB->error());
    while ($row = $xoopsDB->fetchArray($result)) {
        $one['id'] = $row['id'];
        $one['title'] = $row['title'];
        $block[]= $one ;
    }

    return $block;
}
