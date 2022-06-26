<?php

namespace App\Presenters;

use Hemp\Presenter\Presenter;

class ApiProduct extends Presenter
{
    public $snakeCase = true;

    public $visible = ['name','image','price','original_price','state'];

    public function __construct($model)
    {
        parent::__construct($model);
        $model->image = $this->getImage($model);
        $model->original_price = $this->getOriginalPrice();
        $model->price = $this->getPrice();
    }

    public function getImage(){

        if(!empty($this->model->images)){
            $firstImage = $this->model->images[0];
            $image = asset(config('setting.image-server')).$firstImage;
            return  $image;
        }
        return '';

    }

    public function getPrice(){
        return round($this->price);
    }

    public function getOriginalPrice(){
        return round($this->original_price);
    }
}
