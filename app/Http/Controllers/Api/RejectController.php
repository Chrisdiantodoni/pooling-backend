<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\UpdateRejectRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRejectRequest;
use App\Models\Reject;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\PaginationTrait;
use Illuminate\Validation\ValidationException;

class RejectController extends Controller
{
    use PaginationTrait;
    public function storeReject(CreateRejectRequest $request)
    {

        $reject =  Reject::create([
            'reason' => $request->reason,
            'abbreviation' => $request->abbreviation,
        ]);
        return ApiResponse::success($reject, 201, 'Reject Information Added');
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'filter.keyword' => 'string|nullable',
                'page' => 'integer|nullable',
                'page_size' => 'integer|between:1,100|nullable',
            ]);

            $filter = $request->input('filter', []);
            $page = $request->input('page', 1);
            $pageSize = $request->input('page_size', 10);

            $query = Reject::query();

            $query->where(function (Builder $builder) use ($filter) {
                if (isset($filter['keyword'])) {
                    $builder->where(function (Builder $builder) use ($filter) {
                        $keyword = $filter['keyword'];
                        $builder->Where('reason', 'like', '%' . $keyword . '%')
                            ->orWhere('abbreviation', 'like', '%' . $keyword . '%');
                    });
                }
            });


            $sortBy = 'created_at';
            $sortOrder = 'desc';

            $query->orderBy($sortBy, $sortOrder);

            $data = $query->paginate($pageSize, ['*'], 'page', $page);

            $pageInfo = $this->getPaginationDetails($data);

            return ApiResponse::success($data->items(), 200, 'success', $pageInfo);
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        }
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

    public function update(UpdateRejectRequest $request, $id)
    {
        try {
            $reject = Reject::find($id);
            $reject->update([
                'reason' => $request->reason,
                'abbreviation' => $request->abbreviation,
                'status' => $request->status,
            ]);
            return ApiResponse::success($reject, 201, 'Reject Updated');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 401, 'Registration failed');
        }
    }
}
