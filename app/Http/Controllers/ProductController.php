<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends IndexController
{
    public function __construct(){
        $this->template = 'template.product';
    }

    public function index()
    {
        return $this->renderOutput();
    }
}
