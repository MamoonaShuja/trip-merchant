<?php
namespace Modules\SupplierApi\Services;


use Illuminate\Container\Container;
use Illuminate\Support\Facades\Http;
use Modules\SupplierApi\Contracts\Services\FetchRecordContract;
use Modules\SupplierApi\Contracts\Services\SingleRecordContract;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Entities\ApiTourId;
use SimpleXMLElement;

class FetchRecordService implements FetchRecordContract
{
      /**
     * @param ApiSupplier $objApiSupplier
     * @param string $strUrl
     * @return array
     */
    public function getDecodedJson(ApiSupplier $objApiSupplier , string $strUrl):array{
        $objApiSupplier->is_authorization_needed == 1?
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->withBasicAuth($objApiSupplier->is_authorization_needed ? $objApiSupplier->api_key : null ,   $objApiSupplier->is_authorization_needed ? $objApiSupplier->api_secret : null)
                ->get($strUrl)
            :
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($strUrl);
        $json = $response->json();
        if(is_array($json))
            return $json;
        return json_decode($json, true);
    }

    /**
     * @param ApiSupplier $objApiSupplier
     * @param string $strUrl
     * @return array
     */
    public function getDecodedXml(ApiSupplier $objApiSupplier , string $strUrl):array{
        $objApiSupplier->is_authorization_needed ?
        $response = Http::withHeaders([
            'Accept' => 'application/xml',
        ])->withBasicAuth($objApiSupplier->api_key ,   $objApiSupplier->api_secret)
            ->get($strUrl)
            :
        $response = Http::withHeaders([
                'Accept' => 'application/xml',
            ])->get($strUrl);
        $xml = $response->body();
        $xmlElement = new SimpleXMLElement($xml);
        $array = json_decode(json_encode($xmlElement), true);
        return $array;
    }

    /**
     * @param array $allRecordData
     * @param string $strClassName
     * @return object
     */
    public function parseSingleRecord(array $allRecordData, string $strClassName , ApiTourId $objApiTourId): void
    {
        /** @var Container $container */
        $container = app();
        /** @var SingleRecordContract $strClassName */
        $obj = new $strClassName();
        $obj->parse($allRecordData , $container , $objApiTourId);
    }

}
