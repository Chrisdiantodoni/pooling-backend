<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RejectCollection;
use App\Models\Reject;
use Illuminate\Database\Eloquent\Builder;

class RejectController extends Controller
{
    public function storeReject(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'abbreviation' => 'required'
        ]);
        $reject =  Reject::create([
            'reason' => $request->reason,
            'abbreviation' => $request->abbreviation,
        ]);
        return ApiResponse::success($reject, 201, 'Reject Information Added');
    }

    public function index(Request $request)
    {
        // Validate input parameters
        $request->validate([
            'search' => 'string|nullable',
            'status' => 'nullable',
            'sort_by' => 'in:id,status,created_at|nullable',
            'sort_order' => 'in:asc,desc|nullable',
            'per_page' => 'integer|between:1,100|nullable',
        ]);

        $filter = $request->input('filter', []);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $perPage = $request->input('per_page', 10);
        $query = Reject::query();

        $query = $query->where(function (Builder $builder) use ($filter) {
            if (isset($filter['abbreviation'])) {
                $abbreviation = $filter['abbreviation'];
                $builder->where('abbreviation', 'like', '%', $abbreviation);
            }
            if (isset($filter['reason'])) {
                $reason = $filter['reason'];
                $builder->where('reason', 'like', '%', $reason);
            }
        });

        $query->orderBy($sortBy, $sortOrder);
        $rejects = $query->paginate($perPage);

        return ApiResponse::success($rejects, 200, 'success');
    }

    public function show($id)
    {
        $reject = Reject::find($id);
        return ApiResponse::success($reject, 200);
    }

    public function destroy($id)
    {
        $reject = Reject::find($id)->delete();
        return ApiResponse::success($reject, 200, 'Reject Deleted');
    }

    public function update(Request $request, $id)
    {
    }
}
