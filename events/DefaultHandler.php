<?php
namespace app\events;
use see\event\RunAction;
use see\exception\NotFoundException;
class DefaultHandler extends \see\base\Object
{
	public function init(){
        RunAction::on("*",function ($event){
            //todo 安全验证

        });

        //接管404，重设组件 notFound
        $app = \See::$app;
        $app->set('notFound',function($e){
            $result = [
                "error"=>$e->getCode(),
                "msg"=>$e->getMessage(),
                "success"=>false,
                "traceId"=>"",
                "data"=>[]
            ];
            \See::$app->getResponse()->setHeaderJson();
            \See::$app->getResponse()->send(json_encode($result));
        });
	    //版本控制
        $this->versionControl();
        //环境设置
        $this->environment();

        //before runaction
        RunAction::on("*",function(){
            //todo 初始化用户
        });
	}
    /**
     * 版本控制
     * @throws NotFoundException
     * @throws \ErrorException
     */
    private function versionControl(){
        //版本控制 向上兼容
        $routeAll = \See::$app->generateAllRoute();//获取所有route
        $routeArray = [];
        foreach($routeAll['route'] as $row){
            $routeArray = array_merge($routeArray,$row['route']);
        }
        //当前的version
        $version = \See::$app->getRequest()->get('version');
        \See::$app->version = $version;
        //当前的route
        list($route,$_) =  \See::$app->getRequest()->resolve();
        if(stripos($route,'-')){
            $words = explode('-', $route);
            $route = $words[0].ucfirst($words[1]);
        }
        if(strpos($route,'/') !== false){
            // "/"分隔，首字母转小写
            $explodeArr = explode('/',$route);
            array_walk($explodeArr,function(&$item,$key){
                $item = lcfirst($item);
            });
            $route = implode('/',$explodeArr);
        }

        if(!empty($version) && isset(\See::$app->modules_version[$version])){
            $versionName = \See::$app->modules_version[$version];
            $route = preg_replace('/^ver[\d\.]+$/','',$route);

            $versionNum = (int)substr($versionName,strlen('ver'));
            for($i=$versionNum;$i>0;$i--){
                $routeVersion = "ver".$i."/".ltrim($route,'\\');
                $routeVersion = trim($routeVersion,'/');
                if(in_array($routeVersion,$routeArray)){
                    \See::$app->getRequest()->setRoute($routeVersion);
                    return ;
                }
            }

        }
        if(in_array($route,$routeArray)){
            return ;
        }
        throw new NotFoundException("404 not found ^-^.");
    }

    private function environment(){
        $app = \See::$app;
        $version = $app->getRequest()->get('version');
        if(!empty($version) && isset($app->modules_version[$version])){
            $versionName = $app->modules_version[$version];
            if(isset($app->modules[$versionName])){
                $versionModule = $app->modules[$versionName];
                if(isset($versionModule['environment'])){
                    $app->environment = $versionModule['environment'];
                }
            }
        }

    }
}