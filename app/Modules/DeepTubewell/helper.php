<?php

function LogDetailsStore($log_info)
{
    
    $insert = \App\Modules\DeepTubewell\Models\LogInfo::create($log_info);

    if($insert){
        return 1;
    }else{
        return 2;
    }
    
}
