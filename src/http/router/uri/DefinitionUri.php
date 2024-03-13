<?php

namespace Rehark\Carbon\http\router\uri;

class DefinitionUri extends AbstractUri {

    public function isValid(string $uri) : bool {

        if(preg_match('/^((\/(?:[a-zA-Z0-9_-]+|\{[a-zA-Z0-9_-]+\}))+(?:[a-zA-Z0-9_-]*|\{[a-zA-Z0-9_-]+\})+)$|^\/$/', $uri)) {
            return true;
        }
        
        return false;

    }

}