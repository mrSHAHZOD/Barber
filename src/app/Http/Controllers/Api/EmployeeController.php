<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;


class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $service
    ) {}

    #[OA\Get(
    path: "/api/employees",
    operationId: "employeeIndex",
    summary: "Employee list",
    tags: ["Employees"],
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: "Employee list"
        ),
        new OA\Response(
            response: 401,
            description: "Unauthenticated"
        )
    ]
)]
public function index()
{
    return EmployeeResource::collection(
        Employee::latest()->paginate(15)
    );
}

#[OA\Post(
    path: "/api/employees",
    operationId: "employeeStore",
    summary: "Create employee",
    tags: ["Employees"],
    security: [["bearerAuth" => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: [
                "business_id",
                "branch_id",
                "employee_position_id",
                "first_name",
                "last_name",
                "phone",
                "gender"
            ],
            properties: [
                new OA\Property(property: "business_id", type: "integer", example: 1),
                new OA\Property(property: "branch_id", type: "integer", example: 1),
                new OA\Property(property: "employee_position_id", type: "integer", example: 1),
                new OA\Property(property: "user_id", type: "integer", nullable: true, example: 1),
                new OA\Property(property: "first_name", type: "string", example: "Ali"),
                new OA\Property(property: "last_name", type: "string", example: "Valiyev"),
                new OA\Property(property: "email", type: "string", example: "ali@test.com"),
                new OA\Property(property: "phone", type: "string", example: "+998901112233"),
                new OA\Property(property: "birth_date", type: "string", format: "date", example: "1998-01-01"),
                new OA\Property(property: "gender", type: "string", example: "male"),
                new OA\Property(property: "experience_years", type: "integer", example: 5),
                new OA\Property(property: "about", type: "string", example: "Senior Barber"),
                new OA\Property(property: "photo", type: "string", example: "photo.jpg"),
                new OA\Property(property: "is_active", type: "boolean", example: true),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Employee created"),
        new OA\Response(response: 422, description: "Validation error"),
        new OA\Response(response: 401, description: "Unauthenticated")
    ]
)]
public function store(StoreEmployeeRequest $request): JsonResponse
{
    $this->authorize('create', Employee::class);

    $employee = $this->service->create(
        $request->validated()
    );

    return response()->json([
        'success' => true,
        'message' => 'Employee created successfully.',
        'data' => new EmployeeResource($employee),
    ], 201);
}

#[OA\Put(
    path: "/api/employees/{employee}",
    operationId: "employeeUpdate",
    summary: "Update employee",
    tags: ["Employees"],
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(
            name: "employee",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "first_name", type: "string", example: "Ali"),
                new OA\Property(property: "last_name", type: "string", example: "Valiyev"),
                new OA\Property(property: "phone", type: "string", example: "+998901112233"),
                new OA\Property(property: "email", type: "string", example: "ali@test.com"),
                new OA\Property(property: "gender", type: "string", example: "male"),
                new OA\Property(property: "experience_years", type: "integer", example: 5),
                new OA\Property(property: "about", type: "string", example: "Updated info"),
                new OA\Property(property: "photo", type: "string", example: "photo.jpg"),
                new OA\Property(property: "is_active", type: "boolean", example: true),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Employee updated"),
        new OA\Response(response: 404, description: "Employee not found"),
        new OA\Response(response: 422, description: "Validation error")
    ]
)]

public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
{
    $this->authorize('update', $employee);

    $employee = $this->service->update(
        $employee,
        $request->validated()
    );

    return response()->json([
        'success' => true,
        'message' => 'Employee updated successfully.',
        'data' => new EmployeeResource($employee),
    ]);
}
#[OA\Delete(
    path: "/api/employees/{employee}",
    operationId: "employeeDelete",
    summary: "Delete employee",
    tags: ["Employees"],
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(
            name: "employee",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(response: 200, description: "Employee deleted"),
        new OA\Response(response: 404, description: "Employee not found")
    ]
)]
public function destroy(Employee $employee): JsonResponse
{
    $this->authorize('delete', $employee);

    $this->service->delete($employee);

    return response()->json([
        'success' => true,
        'message' => 'Employee deleted successfully.',
    ]);
}
}
