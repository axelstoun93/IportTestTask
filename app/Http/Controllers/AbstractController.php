<?php

namespace App\Http\Controllers;

use App\Models\TopMenu;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    protected string $template;
    protected array $vars = [];

    protected function renderOutput()
    {
        return view(config('setting.theme').'.'.$this->template)->with($this->vars);
    }

}
