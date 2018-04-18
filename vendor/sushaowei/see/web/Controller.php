<?php
namespace see\web;

class Controller extends \see\base\Controller
{
    /**
     * @var \see\web\Request
     */
    public $request;

    public function __construct($id, $module, array $config= [])
    {
        parent::__construct($id, $module, $config);
        $this->request = \See::$app->getRequest();
    }

    public function renderJson( $result ){
        \See::$app->getResponse()->setHeaderJson();
        if(\See::$app->envDev){
            return json_encode($result,JSON_PRETTY_PRINT);
        }
        return json_encode($result);
    }

}
