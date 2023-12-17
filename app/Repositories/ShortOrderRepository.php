<?php

namespace App\Repositories;


use App\Models\EmCaseShortdecisions;

class ShortOrderRepository
{
    public static function getShortOrderList(){
        $shortOrderList=EmCaseShortdecisions::all();
        return $shortOrderList;
    }




}
