<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Services\BusinessService;
use Illuminate\Http\JsonResponse;

class BusinessController extends Controller
{
    public function __construct(
        protected BusinessService $service
    ) {}

    public function index(\Illuminate\Http\Request $request)
    {
        $businesses = $request->user()->businesses()->with([
            'businessType',
            'owner',
        ])->paginate($request->integer('per_page', 15));
        return BusinessResource::collection($businesses);
    }

    public function store(StoreBusinessRequest $request): BusinessResource
    {
        $business = $this->service->create($request->validated());

        return new BusinessResource(
            $business->load('businessType', 'owner')
        );
    }


        public function show(Business $business)
        {
            $this->authorize('view', $business);

            return $this->success(
                new BusinessResource(
                    $business->load('businessType', 'owner')
                ),
                'Business retrieved successfully.'
            );
        }

        public function update(

            UpdateBusinessRequest $request,

            Business $business

        ): BusinessResource {
            $this->authorize('update', $business);
            $business = $this->service->update(
                $business,
                $request->validated()
            );

            return new BusinessResource(

                $business->load('businessType', 'owner')

            );

        }
        public function destroy(Business $business): JsonResponse
        {
            $this->authorize('delete', $business);
            $this->service->delete($business);
            return $this->success(
                [],
                'Business deleted successfully.'
            );
        }
}
