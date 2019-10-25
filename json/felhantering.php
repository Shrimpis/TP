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
    if($code=='400'){
        $status='Bad Request';
    }
    $hideWikiJson = array('code'=> $code,'status'=> $status,'msg' => $msg);
    echo json_encode($hideWikiJson);
}

?>