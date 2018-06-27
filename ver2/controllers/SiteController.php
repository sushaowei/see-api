<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/11 0011
 * Time: 下午 11:35
 */

namespace app\ver2\controllers;


use see\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{   

    /**
     * 首页
     * @return string
     */
    public function actionIndex(){
        $data = ['title'=>'首页','text'=>'Hello!'];
        return $this->renderJson($data);
    }

    public function actionAbout(){
    	return "about".\See::$app->version;
    }

    public function actionCurl(){
        \See::$log->debug("123123123");
        \See::$log->debug("123123123");
        \See::$log->debug("123123123");
        return $this->renderJson($_SERVER);
    }

}

