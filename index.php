<?php
    $controll_action = $_SERVER['REQUEST_URI'];

    //var_dump($controll_action);
    $controll_action = substr($controll_action,1,strlen($controll_action)-1);

    $params  = explode('/',$controll_action);
    $params_count = count($params);

    $otherParams = $params;
    if($params_count>1) {
        $controller = $params[0];
        $action  = $params[1];
        unset($params[0]);
        unset($params[1]);
    }else if($params_count==1) {
        $controller = $params[0];
        $action = 'index';
        unset($params[0]);
    }

    $content = file_get_contents('php://input', 'r');
    //var_dump($content);


    $filename = strtolower($controller).'.php';
    $controller_path = $_SERVER['DOCUMENT_ROOT'].'/controllers/';
    try{
        //var_dump($controller_path);
        if(!file_exists($controller_path.$filename)) {
            throw new Exception('controller '.$filename.' is not exists!');
            return;
        }
        include($controller_path.$filename);

        $classname = ucfirst($controller);
        if(!class_exists($classname)) {
            throw new Excpetion('class '.$classname.' is not exists!');
        }
        $reflecObj = new ReflectionClass($classname);
        if(!$reflecObj->hasMethod($action)){
            throw new Exception('method '.$action.' is not exists!');
        }


        $currentObj = new $classname();
        //echo "classname=$classname,action=$action,params=".$content."<br/>";
        call_user_func([$currentObj,$action],$content);
    }catch (Exception $e){
        var_dump($e->getMessage());
    }
    
    //return;
?>