<?php

namespace Modules\SupplierApi\Console;

use Illuminate\Console\Command;
use Modules\SupplierApi\Contracts\Services\ApiSupplierContract;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScrapTourData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'scrap-tour:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Record From Tour Apis.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly ApiSupplierContract $objApiSupplierService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $strApiName = trim($this->argument("name") , '"');
        $strUniqueId = $this->option("id") ?? null;
        $objSupplierApi = $this->objApiSupplierService->getByName($strApiName);
        $this->objApiSupplierService->getSingleSupplierAllTours($objSupplierApi , $strUniqueId ?? null );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'An api Name.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['name', null, InputOption::VALUE_OPTIONAL, 'Api Name.', null],
            ['id', null, InputOption::VALUE_OPTIONAL, 'Tour Id.', null],
        ];
    }
}
