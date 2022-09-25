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