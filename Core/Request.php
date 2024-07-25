<?php

namespace Core;

class Request {

    public function getParams() {
        return $_REQUEST;
        // return $_POST;
    }

}