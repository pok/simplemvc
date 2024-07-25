<?php

namespace Core;

class Controller {

    protected $sessionManager;

    public function __construct($sessionManager) {
        $this->sessionManager = $sessionManager;
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