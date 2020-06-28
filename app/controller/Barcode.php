<?php
/**
 * User: zengxianmao
 * Date: 2020/6/28
 * Time: 16:09
 */

namespace app\controller;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use think\facade\Request;

class Barcode extends BaseAdmin
{
    public function index(){

    }

    public function qrCode(){
        $content = Request::get('content');
        if(empty($content)) return ;

        $qrCode = new QrCode();
        $qrCode
            ->setText($content)
            ->setSize(300)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
            //->setLabel($title)//title
            //->setLabelFontSize(16);
        //$title && $qrCode->setLabelFontPath('../Resources/font/Arial.ttf')->setLabel($title)->setLabelFontSize(15);
        //1、QrCode生成中文汉字的label的问题：需要引入中文字体，所以需要调用setLabelFontPath方法传入一个中文字体的路径，
        //QrCode默认提供有一个字体为opensans.ttf，在\vendor\endroid\qrcode\assets\font路径下，
        //但QrCode类并未默认调用这个字体，若不调用setLabelFontPath方法设置字体的话，生成中文的label会是小方框。
        //另外需要使用UTF8编码的中文设置label

        $code = $qrCode->generate();
        header('Content-Type: '.$qrCode->getContentType());
        return '<img src="data:' . $qrCode->getContentType() . ';base64,' . $code . '" />';

    }

    public function brCode(){
        $order_id = Request::get('order_id');
        if(empty($order_id)) return ;

        $barcode = new BarcodeGenerator();
        $barcode->setText($order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);


        header('Content-Type: image/png');
        $code = $barcode->generate();
        $rs = [
            'code' => 0,
            'data' => $code,
        ];
        return json($rs);
        //return '<img src="data:image/png;base64,' . $code . '" />';
    }
}