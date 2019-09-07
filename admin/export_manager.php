<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once '../function.php';

include_once '../../tadtools/PHPExcel.php';
require_once '../../tadtools/PHPExcel/IOFactory.php';
/*-----------function區--------------*/

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);  //設定預設顯示的工作表
    $objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
    $objActSheet->setTitle('班級報名管理者');  //設定標題

    $row = 1;
    //標題行 //0年級	1班級代號	2座號	3學生姓名	4性別	5學號	6純特戶	7轉帳戶名	8轉帳戶身份證編號	9存款別	10立帳局號	11存簿帳號	12劃撥帳號	13電話號碼	14地址	15身份別
    //0年級	1班級代號	2座號	3學生姓名	4繳費 	5轉帳戶名	6轉帳戶身份證編號	7存款別(P/G)	8立帳局號	9存簿帳號	10劃撥帳號
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$row, '班級代號')
        ->setCellValue('B'.$row, '填報人完整eamil')
        ->setCellValue('C'.$row, '填報人姓名')   ;

    $sql = ' SELECT *  From '.$xoopsDB->prefix('sign_manager') .
        '     order by class_id , user_email  ';

    $result = $xoopsDB->query($sql);
    while ($stud = $xoopsDB->fetchArray($result)) {
        ++$row;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, $stud['class_id'])
            ->setCellValue('B'.$row, $stud['user_email'])
            ->setCellValue('C'.$row, $stud['user_name'])   ;
    }

    //header('Content-Type: application/vnd.ms-excel');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=manager'.date('mdHi').'.xlsx');
    header('Cache-Control: max-age=0');
    ob_clean();

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
