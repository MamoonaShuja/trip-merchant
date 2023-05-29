<?php

namespace Modules\SupplierApi\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\SupplierApi\Contracts\Services\ApiTourIdContract;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Enum\SupplierResponse;
use Modules\SupplierApi\Services\FetchRecordService;

class FetchToursJob extends FetchRecordService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public ApiTourIdContract $objTourIdService;
    public ApiSupplier $objApiSupplier;
    public string $uniqueTourKey;
    public function __construct(ApiTourIdContract $objTourIdService , ApiSupplier $objApiSupplier , string $uniqueTourKey)
    {
        $this->objTourIdService = $objTourIdService;
        $this->objApiSupplier = $objApiSupplier;
        $this->uniqueTourKey = $uniqueTourKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $strSingleRecordUrl = sprintf($this->objApiSupplier->single_record_url , $this->uniqueTourKey);
        $objApiTourId = $this->objTourIdService->getTourIdByUniqueKey($this->uniqueTourKey);
        $this->objApiSupplier->return_type == SupplierResponse::JSON->value ?
            $this->parseSingleRecord(
                $this->getDecodedJson($this->objApiSupplier, $strSingleRecordUrl) ,
                $this->objApiSupplier->class_name , $objApiTourId)
            :
            $this->parseSingleRecord(
                $this->getDecodedXml($this->objApiSupplier, $strSingleRecordUrl) ,
                $this->objApiSupplier->class_name , $objApiTourId);
    }
}
