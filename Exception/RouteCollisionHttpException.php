<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

class RouteCollisionHttpException extends HttpException{
    
    public function __construct(\Exception $previous = null, int $code = 0, array $headers = array())
    {
        $message = 'route collision';
        parent::__construct(500, $message, $previous, $headers, $code);
    }
}
