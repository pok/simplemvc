<?php

namespace Core;

class Controller {

    protected $sessionManager;

    public function __construct($sessionManager) {
        $this->sessionManager = $sessionManager;
    }

}