<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $students = Student::paginate(10); // Paginate with 10 items per page
            return response()->json([
                'status' => 'success',
                'message' => 'Students retrieved successfully',
                'data' => $students->items(),
                'meta' => [
                    'current_page' => $students->currentPage(),
                    'last_page' => $students->lastPage(),
                    'per_page' => $students->perPage(),
                    'total' => $students->total()
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve students',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        try {
            $student = Student::create($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Student created successfully',
                'data' => $student
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Student retrieved successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        try {
            $student->update($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully',
                'data' => $student
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Student deleted successfully',
                'data' => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
