<?php

function hantering($code,$msg){
    $status='';
    if($code=='200'){
        $status='OK';
    }
    if($code=='201'){
        $status='Created';
    }
    if($code=='202'){
        $status='Accepted';
    }
    if($code=='204'){
        $status='No Content';
    }
    if($code == '301'){
        $status = 'Move Permanently';
    }
    if($code=='400'){
        $status='Bad Request';
    }
    if($code = '401'){
        $status = 'Unauthorized';
    }
    if($code == '404'){
        $status = 'Not Found';
    }
    if($code == '415'){
        $status = 'Unsupported Media Type';
    }
    $errorJson = array('code'=> $code,'status'=> $status,'msg' => $msg);
    http_response_code($code);
    echo json_encode($errorJson);
}

?>