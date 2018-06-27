<?php
namespace app\console;

use see\console\Controller;

class SiteController extends Controller
{
    public function actionIndex($a,$b){
        return "hello console $a,$b";
    }

    public function actionTest(){
        $curl = new \see\helper\MyCurl("http://localhost:9002/site/curl?version=v2.0");
        // $curl = new \see\helper\MyCurl("http://localhost:3000/test");
        // $curl->setOpt(CURLOPT_HEADER,true);
        \See::$log->debug("123123123");
        \See::$log->debug("123123123");
        return $curl->get();
    }
}
