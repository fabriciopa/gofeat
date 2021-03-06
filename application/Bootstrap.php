<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDbRegistry() {
        $this->bootstrap('multidb');
        $multidb = $this->getPluginResource('multidb');
        $multidb->init();
        Zend_Registry::set('db_default', $multidb->getDb('name1'));
        //Zend_Registry::set('db_another', $multidb->getDb('name2'));
        //Zend_Registry::set('db_dol', $multidb->getDb('name3'));

        /*if ($link = mysql_connect('localhost', 'root', 'root')) {
            //do queries
        } else {
            //use files
        }
        var_dump($link);*/
    
        return $multidb->getDb();
    }

    protected function _initRouter() {

        $this->bootstrap('FrontController');

        $front = $this->getResource('FrontController');
        $front->addModuleDirectory(APPLICATION_PATH . '/modules');
        $front->setControllerDirectory(
                array(
                    'site' => APPLICATION_PATH . '/modules/site/controllers'
                )
        );

        $front->setDefaultModule('site');

        //If set to 'true', the ErrorController won't be activated
        $front->throwExceptions(false);


    }

    protected function _initSetupBaseUrl() {
        $this->bootstrap('frontcontroller');
        $controller = Zend_Controller_Front::getInstance();
        $controller->setBaseUrl('/gofeat/');
        Zend_Registry::set('baseurl', '/gofeat/');
    }

    protected function _initAcl() {
        $front = $this->getResource('FrontController');
        $front->registerPlugin(new Plugin_Permissao());
    }

}