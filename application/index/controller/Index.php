<?php
namespace app\index\controller;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Cell;

use app\index\model\Table1 as Table1Model;
use app\index\model\Table2 as Table2Model;


class Index
{
    public function index()
    {

    }

    public function daoru1(){
        // dump(1);die;
        // dump(ROOT_PATH);die;
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="public/1.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数


        //$j是从第几行开始读取数据{
        for($j=2;$j<=$highestRow;$j++){
            $str="";
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            {
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|*|';//读取单元格
            }
            $str=mb_convert_encoding($str,'utf-8','auto');//根据自己编码修改
            $strs = explode("|*|",$str);


            $user=new Table1Model;
            $user->name=$strs[2];
            $user->tel='';
            $user->mobile=$strs[5];
            $user->laiyuan='';


            /* $user=new Table2Model;
            $user->name=$strs[2];
            $user->tel=$strs[6];
            $user->laiyuan=$strs[8]; */

            $result=$user->save();
            // $result=$user->fetchSql()->save();
            // return $user::getLastSql();
            /*if($result){
                return '导入成功';
            }*/
            //echo $sql;
            //exit
        }
    }


}



/**
 *
 *
table1是宏脉表，是最后需要的表，信息来源开始为空，可能有tel和mobile两个字段   1.xls
table2是医汇通表有 name ,tel ,laiyuan     2.xls
按顺序执行

UPDATE table1 SET laiyuan='';   把null统一改成空值
UPDATE table1 SET mobile=tel WHERE mobile='';
或者 UPDATE table1 SET tel=mobile WHERE tel='';

-- select * from table1 where mobile='';



SELECT *,COUNT(*) AS NUM FROM table2 GROUP BY `name` HAVING COUNT(*)>1;-- 查询table2重名记录






UPDATE table1 INNER JOIN table2 ON table1.tel = table2.tel SET table1.laiyuan=table2.laiyuan; -- 更新手机号相同部分726

SELECT * FROM table1 INNER JOIN table2 ON table1.tel=table2.tel WHERE table1.`laiyuan`='' AND table1.`tel`!=''; -- 查询tel相同部分11

UPDATE table1 INNER JOIN table2 ON table1.tel=table2.tel SET table1.laiyuan=table2.laiyuan WHERE table1.`laiyuan`='' AND table1.`tel`!=''; -- 更新tel相同部分11

SELECT *,COUNT(*) AS NUM FROM table1,table2 WHERE table1.name=table2.name AND table1.`laiyuan`='' GROUP BY table1.`name` HAVING COUNT(*)=1; -- 查询名字相同部分62



UPDATE table1 AS a
INNER JOIN (SELECT table2.`laiyuan`,table2.`name`,COUNT(*) AS NUM FROM table1,table2 WHERE table1.name=table2.name AND table1.`laiyuan`='' GROUP BY table1.`name` HAVING COUNT(*)=1) AS b
ON a.name=b.name SET a.laiyuan=b.laiyuan; -- 更新姓名相同部分 62


 */