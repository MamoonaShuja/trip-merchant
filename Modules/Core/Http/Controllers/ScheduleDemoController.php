<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Contracts\Services\ScheduleDemoContract;
use Modules\Core\Http\Requests\ScheduleDemoRequest;
use Modules\Core\Transformers\ScheduleDemoTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ScheduleDemoController extends Controller
{

    public function __construct(
        private readonly ScheduleDemoContract $objDemoService
    )
    {
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getScheduleDemos(): JsonResponse
    {
        $demos = $this->objDemoService->get();
        return apiResponse()->pagination($demos)->success(ScheduleDemoTransformer::collection($demos));
    }


    /**
     * @param ScheduleDemoRequest $demoRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(ScheduleDemoRequest $demoRequest): JsonResponse
    {

        $demo = $this->objDemoService->create($demoRequest);
        return apiResponse()->success(new ScheduleDemoTransformer($demo));
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getById(string $id): JsonResponse
    {
        $objDemo = $this->objDemoService->findByUuId($id);

        if (is_null($objDemo)) {
            throw new \Exception("Not Found.", 404);
        }

        return apiResponse()->success(new ScheduleDemoTransformer($objDemo));
    }


    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('core::edit');
    }


    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * @param $id
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function destroy($id): JsonResponse
    {
        $objDemo = $this->objDemoService->findByUuId($id);
        if (is_null($objDemo)) {
            throw new \Exception("Not Found.", 404);
        }
        $objDemo->delete();
        return apiResponse()->success("Deleted");
    }
}
