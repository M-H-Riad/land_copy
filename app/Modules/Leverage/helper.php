<?php

/**
 *	Leverage Helper  
 */

function getLeverageProductList(){
    return \App\Modules\Leverage\Models\LeverageProduct::orderBy('title')->pluck('title','id');
}
