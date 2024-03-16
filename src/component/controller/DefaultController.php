<?php

namespace Rehark\Carbon\component\controller;

use Rehark\Carbon\http\response\Response;

final class DefaultController extends AbstractController {
    
    public function serverStatus() : Response {
        return new Response(200, 'Server on.');
    }

    public function emptyResponse() : void {
        return;
    }

}