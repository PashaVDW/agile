<?php

namespace App\Http\Controllers;

use App\Enums\ActiveTypeEnum;
use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Services\AssignmentService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private AssignmentService $assignmentService;
    private SearchService $searchService;

    public function __construct(AssignmentService $assignmentService, SearchService $searchService)
    {
        $this->searchService = $searchService;
        $this->assignmentService = $assignmentService;
    }

    public function index(Request $request)
    {
        $query = $this->assignmentService->getAssignments();
        $bindings = array_keys(request()->query());

        if ($request->has("search") && $request->search != '') {
            $this->searchService->search($query, $request->search, Assignment::class);
        }

        $assignments = $query->paginate(10)->appends(request()->query());


        return view('admin.assignments.index', [
            'assignments' => $assignments,
            'bindings' => $bindings,
        ]);
    }

    public function create()
    {
        return view('admin.assignments.form');
    }

    public function store(AssignmentRequest $request)
    {
        $this->assignmentService->storeAssignment($request);
        return to_route('admin.assignments.index');
    }

    public function show($id)
    {
        $assignment = Assignment::findOrFail($id);
        return view('admin.assignments.form', [
            'assignment' => $assignment,
        ]);
    }

    public function update(AssignmentRequest $request, $id)
    {
        $this->assignmentService->updateAssignment($request, $id);
        return to_route('admin.assignments.index');
    }

    public function delete($id)
    {
        $this->assignmentService->deleteAssignment($id);
        return to_route('admin.assignments.index');
    }
}
