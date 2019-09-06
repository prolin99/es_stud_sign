<?php

namespace XoopsModules\Es_stud_sign;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{
    public static function chk_manger()
    {
        global $xoopsDB;
        $sql = 'SELECT  1  FROM ' . $xoopsDB->prefix('sign_manager');
        $result=$xoopsDB->query($sql);
        if(empty($result)) return false;
        return true;
    }

    public static function go_manger()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('sign_manager') . "(
            `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `class_id` varchar(10) NOT NULL,
            `user_email` varchar(80) NOT NULL,
            `user_name` varchar(80) DEFAULT  NULL
            ) ENGINE=MyISAM  COMMENT='校園報名班級管理者'  ; ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());
    }


}
