<?php

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

if (!function_exists('redirectWithoutInertia')) {
    function redirectWithoutInertia(string $url)
    {
        return response('', SymfonyResponse::HTTP_CONFLICT)->header('x-inertia-location', route($url));
    }
}
