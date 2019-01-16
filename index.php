<?php

require_once('core.php');


$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
         $controller = 'Controller\Main';
         $action='index';
        break;
    
    default: 
        $uridata = explode('/',$request);
        if(count($uridata)==2) {
            $controller = 'Controller\\'.$uridata[1];
            $action = 'index';
        }
        elseif(count($uridata)>2){
            $controller = 'Controller\\'.$uridata[1];
            $action = $uridata[2];
            if(strpos($action,'?')!==FALSE) {
                $arr = explode('?',$action);
                $action = $arr[0];
                $params = $arr[1];
                
            }
        }
       
        else { header('HTTP/1.0 404 Not Found', true, 404); die; }
       
        
        break;
}

if(class_exists($controller)) $controller = new $controller;
else  { header('HTTP/1.0 404 Not Found', true, 404); die; }
$controller->db = $db;
if($params) $controller->params = explode('&',$params);
if(method_exists($controller,'before')) $controller->before();
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $data =  $controller->$action();
    if(is_array($data)) echo json_encode($data);
    else echo $data;
    exit(); 
}

 
require('index.html');
exit();
