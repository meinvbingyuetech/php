- 组件
    ```
    链接: https://pan.baidu.com/s/1SpsV0EHrVep_2U3rvCOVWg 提取码: 1au1
    ```

```php

<?php
namespace app\index\controller;

use think\Controller;

class Index extends controller
{

    public function export()
    {
        $offset = 0;
        $limit  = 10000;
        $order  = 'desc';
        $sort   = 'id';
        $result  = db('guestbook')->order($sort,$order)->limit($offset.','.$limit)->select();
        $head = ['登记时间','姓名','电话','留言','金额','城市','IP地址'];
        $body = [];
        foreach ($result as $item) {
            $body[] = [
                $item['add_time'],
                $item['username'],
                $item['phone'],
                $item['message'],
                $item['money'],
                $item['city'],
                $item['ip'],
            ];
        }
        $this->excel_out($head,$body,'数据',date('YmdHis'));
    }

    /**
     * 导出excel
     * @param $head array 表头数据
     * @param $body  array 主体数据
     * @param $name string 表格标签名
     * @param $filename string 导出的文件名
     * @param $widths array 每列的宽度(可省略)
     *
     * Demo:
     * 		$head = ['姓名','身份证','性别','地址'];
     *$body = [
     *['周杰伦','500242197605300015','男','四川省成都市双流县成都信息工程大学航空港校区'],
     *['蔡依林','500242197605300014','女','成都市武侯区成科西路3号'],
     *];
     *excel_out($head,$body,'测试','test');
     */
    public function excel_out($head,$body,$name,$filename,$widths=[],$superHead='')
    {
        require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/extend/excel/PHPExcel.php');
        $objPHPExcel = new \PHPExcel();
        $startRow = 1;  //从第一行开始
        //超级表头（合并单元格，显示一行字）
        if($superHead){
            $j = $i = 'A';
            $count = count($head)-1;
            for($index=0;$index<$count;$index++){
                $j++;
            }
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($i.$startRow.':'.$j.$startRow);   //合并
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.$startRow, $superHead);
            $objPHPExcel->getActiveSheet()->getStyle($i.$startRow)->applyFromArray(
                array(
                    'font' => array (
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle($i.$startRow.':'.$j.$startRow)->getFont()->setSize(20);
            $startRow++;
        }

        //表头
        $i='A';
        foreach($head as $item){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.$startRow, $item);
            $i++;
        }
        $count = count($head);

        //主体数据
        foreach($body as $key=>$value){
            $startRow++;
            $index='A';
            for($i=0;$i<$count;$i++){
                $objPHPExcel->getActiveSheet()->getStyle($index.$startRow)->getNumberFormat()->setFormatCode("@"); //文本格式
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($index.$startRow, $value[$i]);
                $index++;
            }
        }

        //设置宽度
        if($widths){
            $index='A';
            for($i=0;$i<$count;$i++){
                $objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth($widths[$i]);
                $index++;
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle($name);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        //	exit;
    }
}

```
