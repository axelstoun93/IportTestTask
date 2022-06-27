<?php

namespace App\Http\Controllers\Api\V1;

use App\Components\Iport\Api\Exception\IportCurlException;
use App\Components\Iport\Api\Iport;
use App\Components\Iport\Api\IportMultiCurl;
use App\Components\Iport\Parser\IportXmlProductParser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadXmlRequest;
use App\Models\Product;
use App\Service\LoadProductService;


class UploadXmlFileController extends Controller
{
    private $xmlParser;
    private $apiIport;
    private $productModel;
    private $loadService;

    public function __construct(){
        $this->xmlParser = new IportXmlProductParser();
        $this->apiIport = new Iport();
        $this->apiIport->setCurlClient(new IportMultiCurl());
        $this->productModel = new Product();
        $this->loadService = new LoadProductService();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadXmlRequest $request)
    {

        try {

        $filePatch = $request->file('file')->getPathname();
        $this->xmlParser->loadFile($filePatch);
        $codeProduct = $this->loadService->update($this->apiIport,$this->xmlParser,$this->productModel);
        $this->loadService->deactivateProductNotXmlFile($codeProduct,$this->productModel);
        $loadProductFile = $this->loadService->getCountProduct();
        $activeProduct = $this->productModel->getActiveProduct();

            return response()->json([
                                        'message' => "Добавлено, обновлено $loadProductFile продуктов, из них активировано $activeProduct",
                                    ], 200);
        } catch (\Exception $exception) {

            $message = 'Ошибка при обновлении продуктов, повторите попытку';
            if($exception instanceof IportCurlException){
                $message = $exception->getMessage();
            }

            return response()->json([
                                        'message' =>  $message
                                    ], 500);
        }
    }

}
