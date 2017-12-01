<?php
namespace app\index\controller;

// use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;
use \Spreadsheet_Excel_Reader;


class Index
{
    public function index()
    {
        $data = new Spreadsheet_Excel_Reader();
        var_dump($data);die;


        // $data = \PhpOffice\PhpSpreadsheet\IOFactory::load("1.xls");
        $data->read("1.xls");



        for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
          for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
         echo $data->sheets[0]['cells'][$i][$j],'<br/>';
          }
        }


        // var_dump($spreadsheet);
        // return json($spreadsheet);
    }
}
