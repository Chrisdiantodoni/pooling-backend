<?php

namespace App\Http\Controllers\Api;

use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMotorcycleRequest;
use App\Http\Requests\UpdateMotorcycleRequest;
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
                'filter.area_id' => 'integer|required',
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        }

        $filter = $request->input('filter', []);
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        $query = Motorcycle::query();

        $query->join('dealer_motorcycles', 'motorcycles.id', '=', 'dealer_motorcycles.motorcycle_id');

        $query->where(function (Builder $builder) use ($filter) {
            if (isset($filter['keyword'])) {
                $builder->where(function (Builder $builder) use ($filter) {
                    $keyword = $filter['keyword'];
                    $builder->orWhere('type', 'like', '%' . $keyword . '%')
                        ->orWhere('color', 'like', '%' . $keyword . '%');
                });
            }
            if (isset($filter['area_id'])) {
                $builder->where('area_id', $filter['area_id']);
            }

            if (isset($filter['otr'])) {
                $builder->where('otr', '<=', $filter['otr']);
            }
        });

        $paginator = $query->paginate($pageSize, ['*'], 'page', $page);

        $formattedData = collect($paginator->items())->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'color' => $item->color,
                'otr' => $item->otr,
                'user_id' => $item->user_id,
                'area_id' => $item->area_id,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'dealers' => $item->dealers->map(function ($dealer) {
                    return [
                        'motorcycle_id' => $dealer->pivot->motorcycle_id,
                        'dealer_code' => $dealer->pivot->dealer_code,
                        'dealer' => [
                            'dealer_name' => $dealer->dealer_name,
                            // Include other dealer information as needed
                        ],
                    ];
                }),
            ];
        });

        $pageInfo = $this->getPaginationDetails($formattedData);
        return ApiResponse::success($formattedData->toArray(), 200, 'success', $pageInfo);
    }


    public function show($id)
    {
        $motorcycle = Motorcycle::find($id);
        return ApiResponse::success($motorcycle, 200, 'success');
    }
    public function update(UpdateMotorcycleRequest $request, $id)
    {
        try {
            $motorcycle = Motorcycle::find($id);
            $motorcycle->update([
                'type' => $request->type,
                'color' => $request->color,
                'otr' => $request->otr,
                'user_id' => $request->user_id,
                'area_id' => $request->area_id,
            ]);
            $motorcycle->dealers()->detach();
            foreach ($request->dealer_code as $dealer_code) {
                DB::table('dealer_motorcycles')->insert([
                    'dealer_code' => $dealer_code,
                    'motorcycle_id' => $motorcycle->id,
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
            'user_id' => $request->user_id,
            'area_id' => $request->area_id,
        ]);

        foreach ($request->dealer_code as $dealer_code) {
            DB::table('dealer_motorcycles')->insert([
                'dealer_code' => $dealer_code,
                'motorcycle_id' => $motorcycle->id,
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
