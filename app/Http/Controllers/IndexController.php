<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends AbstractController
{
    public function __construct(){
        $this->template = 'template.index';
    }

    public function index()
    {
        return $this->renderOutput();
    }
}
