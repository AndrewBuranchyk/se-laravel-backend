<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use App\Http\Requests\{DepartmentStoreRequest, DepartmentUpdateRequest};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return DepartmentResource::collection(Department::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @return DepartmentResource
     */
    public function store(DepartmentStoreRequest $request): DepartmentResource
    {
        $validatedFields = $request->validated();
        $cong = Department::create($validatedFields);
        return new DepartmentResource($cong);
    }

    /**
     * Display the specified resource.
     *
     * @param Department $department
     * @return DepartmentResource
     */
    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param Department $department
     * @return JsonResponse
     */
    public function update(DepartmentUpdateRequest $request, Department $department): JsonResponse
    {
        $validatedFields = $request->validated();
        $department->update($validatedFields);
        return (new DepartmentResource($department))
            ->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     * @return bool | null
     */
   public function destroy(Department $department): bool | null
    {
        return $department->delete();
    }
}
