<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

if(!function_exists('route_is')){
    function route_is($route=null){
        if(Request::routeIs($route) || Route::currentRouteName() == $route){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('route_is')){
    function route_is($routes=[]){
        foreach($routes as $route){
            if(Request::routeIs($route) || Route::currentRouteName() == $route){
                return true;
            }else{
                return false;
            }
        }
    }
}


if(!function_exists('notify')){
    function notify($message , $type='success'){
        return array(
            'message'=> $message,
            'alert-type' => $type,
        );
    }
}


if(!function_exists('alert')){
    function alert($message , $type='success'){
        return array(
            'alert'=> $message,
            'alert-type' => $type,
        );
    }
}

/**
 * Generate a random string, using a cryptographically secure 
 * pseudorandom number generator (random_int)
 *
 * This function uses type hints now (PHP 7+ only), but it was originally
 * written for PHP 5 as well.
 * 
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 * 
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
    $keyspace = str_shuffle($keyspace );
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}


/**
 * return if auth user has a permission
 * 
 * @param string $permission
 * @return bool
 */
if(!function_exists('can')){
    function can($permission){
        return (ucfirst(auth('web')->user()->roles->first()->name) == 'Super-admin') || auth('web')->user()->hasPermissionTo($permission);
    }
}
