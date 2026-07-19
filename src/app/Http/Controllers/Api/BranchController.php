<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class BranchController extends Controller
{
     public function __construct(
        protected BranchService $service
    ) {}


    #[OA\Get(
    path: '/api/branches',
    summary: 'Get all branches',
    tags: ['Branches'],
    security: [['bearerAuth' => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Branches retrieved successfully'
        ),
        new OA\Response(
            response: 401,
            description: 'Unauthenticated'
        )
    ]
)]
       public function index(): AnonymousResourceCollection
    {
        $branches = Branch::with('business')
            ->latest()
            ->paginate(request('per_page', 15));

        return BranchResource::collection($branches);
    }


    #[OA\Post(
        path: '/api/branches',
        summary: 'Create Branch',
        security: [['bearerAuth' => []]],
        tags: ['Branches'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['business_id', 'name', 'address'],
                properties: [
                    new OA\Property(property: 'business_id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Yunusobod Branch'),
                    new OA\Property(property: 'phone', type: 'string', example: '+998901112233'),
                    new OA\Property(property: 'email', type: 'string', example: 'branch@test.com'),
                    new OA\Property(property: 'address', type: 'string', example: 'Tashkent'),
                    new OA\Property(property: 'latitude', type: 'number', format: 'float', example: 41.311),
                    new OA\Property(property: 'longitude', type: 'number', format: 'float', example: 69.279),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Branch created successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
     public function store(StoreBranchRequest $request): JsonResponse
    {
        $branch = $this->service->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully.',
            'data' => new BranchResource($branch->load('business')),
        ], 201);
    }

    #[OA\Get(
    path: '/api/branches/{branch}',
    summary: 'Show branch',
    tags: ['Branches'],
    security: [['bearerAuth' => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Branch retrieved successfully'
        ),
        new OA\Response(
            response: 404,
            description: 'Branch not found'
        )
    ]
)]
     public function show(Branch $branch): BranchResource
    {
        $this->authorize('view', $branch);

        return new BranchResource(
            $branch->load('business')
        );
    }

    #[OA\Put(
    path: '/api/branches/{branch}',
    summary: 'Update branch',
    tags: ['Branches'],
    security: [['bearerAuth' => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Branch updated successfully'
        ),
        new OA\Response(
            response: 404,
            description: 'Branch not found'
        )
    ]
)]
    public function update(
        UpdateBranchRequest $request,
        Branch $branch
    ): JsonResponse {
        $this->authorize('update', $branch);

        $branch = $this->service->update(
            $branch,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
            'data' => new BranchResource($branch->load('business')),
        ]);
    }


    #[OA\Delete(
    path: '/api/branches/{branch}',
    summary: 'Delete branch',
    tags: ['Branches'],
    security: [['bearerAuth' => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Branch deleted successfully'
        ),
        new OA\Response(
            response: 404,
            description: 'Branch not found'
        )
    ]
)]
    public function destroy(Branch $branch): JsonResponse
    {
        $this->authorize('delete', $branch);

        $this->service->delete($branch);

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }
}
