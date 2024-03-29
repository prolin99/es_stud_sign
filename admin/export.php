<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-05-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once 'header.php';
include_once '../function.php';

require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'; //引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php'; //引入PHPExcel_IOFactory 物件庫

/*-----------function區--------------*/

/*-----------執行動作判斷區----------*/
if ($_GET['mid']) {
    $mid = $_GET['mid'];
    //echo $mid  ;

    //取得中文班名
    $class_list_c = es_class_name_list_c('long');

    //取得報名表格式
    $kind_get = get_sign_kind($mid);
    $kind = $kind_get[$mid];
    //var_dump($kind) ;

    //取得報名學生資料
    $sign_studs = get_sign_data($mid, 'all');
    //var_dump($sign_studs) ;
    //die() ;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);  //設定預設顯示的工作表
    $objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
    $objActSheet->setTitle('校園報名');  //設定標題
    //設定框線
    $objBorder = $objActSheet->getDefaultStyle()->getBorders();
    $objBorder->getBottom()
              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
              ->getColor()->setRGB('000000');
    $objActSheet->getDefaultRowDimension()->setRowHeight(15);

    $row = 1;
       //標題行
          $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, 'NO.')
            ->setCellValue('B'.$row, '班級')
            ->setCellValue('C'.$row, '順位')
            ->setCellValue('D'.$row, '學生姓名');
      //擷取欄位
      $col = 'D';

    foreach ($kind['field_get']  as $k => $v) {
        ++$col;
        $col_str = $col.$row;
        $mystr = $DEF_SET['export'][$v];
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, $mystr);
    }

      //輸入欄位
      foreach ($kind['field_input']  as $k => $v) {
          ++$col;
          $col_str = $col.$row;

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, $v[1]);
      }

      //是否正取
    ++$col;
    $col_str = $col.$row;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, '錄取');

        //資料區
        foreach ($sign_studs  as $ci => $class_stud) {
            $stud_order = 0;    //順位
        foreach ($class_stud  as $order => $stud) {
            ++$row;
            ++$stud_order;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$row, $row - 1)
                ->setCellValue('B'.$row, $class_list_c[$stud['class_id']])
                ->setCellValue('C'.$row, $stud['order_pos'])
                ->setCellValue('D'.$row, $stud['stud_name']);
            //擷取欄位
            $col = 'D';

            foreach ($kind['field_get']  as $k => $v) {
                ++$col;
                $col_str = $col.$row;

                $my_data = $stud['get_field_2'][$v];

                    //日期格式
                    if ($v == 'birthday') {
                        $b_date = preg_split("/[-\/]/", $stud['get_field_2'][$v]);
                        //var_dump($b_date) ;

                        $my_data = "=date({$b_date[0]}, {$b_date[1]}, {$b_date[2]}) ";
                        //die($my_data) ;
                        //$my_data = new DateTime("{$b_date[0]}/{$b_date[1]}/{$b_date[2]}" );
                        //$my_data = "{$b_date[0]}-{$b_date[1]}-{$b_date[2]}";

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, $my_data);

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->getStyle($col_str)
                            ->getNumberFormat()
                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
                        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, PHPExcel_Shared_Date::PHPToExcel($my_data )  );

                    }else
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, $my_data);
            }

            //輸入欄位
            foreach ($kind['field_input']  as $k => $v) {
                ++$col;
                $col_str = $col.$row;
                $my_data = $stud['in_'.$v[0]];
                    //日期格式
                    if ($v[2] == 'd') {
                        $b_date = preg_split("/[-\/]/", $my_data);
                        $my_data = "=date({$b_date[0]}, {$b_date[1]}, {$b_date[2]}) ";
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->getStyle($col_str)
                            ->getNumberFormat()
                            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
                    }

                if ($v[2] == 'o') {    //選項
                        $my_data = $v[5][$my_data];
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, $my_data);
            }

            //是否正取
            ++$col;
            $col_str = $col.$row;
            if ($stud_order <= $kind['stud_get']) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, '正取');
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str, '備取');
            }
        }
        }

    //header('Content-Type: application/vnd.ms-excel');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=sign'.date('mdHi').'.xlsx');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_clean();
    $objWriter->save('php://output');
    exit;
}
