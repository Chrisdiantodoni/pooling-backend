<?php

namespace App\Http\Controllers\Api;

use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMotorcycleRequest;
use App\Http\Requests\UpdateMotorcycleRequest;
use App\Http\Resources\MotorcycleResource;
use App\Models\DealerMotorCycle;
use App\Models\Motorcycle;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MotorcycleController extends Controller
{
    use PaginationTrait;
    public function index(Request $request)
    {
        try {
            $request->validate([
                'filter.keyword' => 'string|nullable',
                'page' => 'integer|nullable',
                'page_size' => 'integer|between:1,100|nullable',
                'filter.area_uuid' => 'string|required',
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        }

        $filter = $request->input('filter', []);
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        $query = Motorcycle::query()->with('dealers');

        $query->where(function (Builder $builder) use ($filter) {
            if (isset($filter['keyword'])) {
                $builder->where(function (Builder $builder) use ($filter) {
                    $keyword = $filter['keyword'];
                    $builder->orWhere('type', 'like', '%' . $keyword . '%')
                        ->orWhere('color', 'like', '%' . $keyword . '%');
                });
            }
            if (isset($filter['area_uuid'])) {
                $builder->where('area_uuid', $filter['area_uuid']);
            }

            if (isset($filter['otr'])) {
                $builder->where('otr', '<=', $filter['otr']);
            }
        });

        $motorcycles = MotorcycleResource::collection($query->paginate($pageSize, ['*'], 'page', $page));

        $pageInfo = $this->getPaginationDetails($motorcycles);

        return ApiResponse::success($motorcycles->items(), 200, 'success', $pageInfo);
    }


    public function show($id)
    {
        $motorcycle = Motorcycle::with('dealers')->find($id);
        if (!$motorcycle) {
            return ApiResponse::error(null, 404, 'Motorcycle not found');
        }
        $resource =  new MotorcycleResource($motorcycle);
        return ApiResponse::success($resource, 200, 'success');
    }
    public function update(UpdateMotorcycleRequest $request, $id)
    {
        try {
            $motorcycle = Motorcycle::find($id);
            if (!$motorcycle) {
                return ApiResponse::error(null, 404, 'Motorcycle not found');
            }
            $motorcycle->update([
                'type' => $request->type,
                'color' => $request->color,
                'otr' => $request->otr,
                'user_uuid' => $request->user_uuid,
                'area_uuid' => $request->area_uuid,
            ]);
            $motorcycle->dealers()->detach();
            foreach ($request->dealer_code as $dealer_code) {
                DB::table('dealer_motorcycles')->insert([
                    'dealer_code' => $dealer_code,
                    'motorcycle_uuid' => $motorcycle->motorcycle_uuid,
                ]);
            }
            return ApiResponse::success($motorcycle, 201, 'Motorcycle Updated');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 401, 'Update failed');
        }
    }
    public function store(CreateMotorcycleRequest $request)
    {
        $motorcycle = Motorcycle::create([
            'type' => $request->type,
            'color' => $request->color,
            'otr' => $request->otr,
            'user_uuid' => $request->user_uuid,
            'area_uuid' => $request->area_uuid,
        ]);

        foreach ($request->dealer_code as $dealer_code) {
            DB::table('dealer_motorcycles')->insert([
                'dealer_code' => $dealer_code,
                'motorcycle_uuid' => $motorcycle->motorcycle_uuid,
            ]);
        }
        return ApiResponse::success($motorcycle, 201, 'success');
    }
    public function destroy($id)
    {
        $motorcycle = Motorcycle::find($id);

        if (!$motorcycle) {
            return ApiResponse::error(null, 404, 'Motorcycle not found');
        }
        $motorcycle->delete();
        return ApiResponse::success($motorcycle, 200, 'Reject Deleted');
    }
}
