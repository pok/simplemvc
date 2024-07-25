<?php

namespace Core;

class Controller {

    protected $sessionManager;
    protected $request;

    public function __construct($sessionManager, $request) {
        $this->sessionManager = $sessionManager;
        $this->request = $request;
    }

    public function renderTemplate($templateName, $data = array()) {
        require_once(APPROOT.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.$templateName.'.php');
    }

    public function renderStandardTemplate($templateName, $data = array()) {
        require_once(APPROOT.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'StandardLayout/Header.php');
        require_once(APPROOT.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.$templateName.'.php');
        require_once(APPROOT.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'StandardLayout/Footer.php');
    }

}