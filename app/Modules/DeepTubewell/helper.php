<?php

function LogDetailsStore($user_id,$module_name,$menu_name,$operation)
{
    
    $data['user_id']     = $user_id;
    $data['module_name'] = $module_name;
    $data['menu_name']   = $menu_name;
    $data['operation']   = $operation;

    $insert = \App\Modules\DeepTubewell\Models\LogInfo::create($data);

    if($insert){
        return 1;
    }else{
        return 2;
    }
    
}
