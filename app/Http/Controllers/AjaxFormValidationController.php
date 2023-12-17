<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxFormValidationController extends Controller
{
    //
    public function validateStoreOnTrialForm(Request $request)
    {
         var_dump($_FILES);
         exit();
    }
}
