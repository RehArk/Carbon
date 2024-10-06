<?php

namespace Rehark\Carbon\component\controller;

use DateTime;
use Rehark\Carbon\http\response\Response;

final class DefaultController extends AbstractController
{
    
    private DateTime $serverDate;

    public function __construct(DateTime $serverDate)
    {
        $this->serverDate = $serverDate;
    }

    public function serverStatus(DateTime $actualDate): Response
    {
        return new Response(200, 'Server on at ' . $this->serverDate->format('Y-m-d H:i:s') . '.');
    }

    public function emptyResponse(): void
    {
        return;
    }
}
