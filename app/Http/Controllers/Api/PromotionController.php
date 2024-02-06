<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\promotion;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePromotionRequest;
use App\Http\Requests\UpdatepromotionRequest;
use App\Http\Resources\PromotionResources;
use App\Models\AreaPromotion;
use App\Traits\PaginationTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PaginationTrait;

    public function index(Request $request)
    {
        try {
            $request->validate([
                'filter.keyword' => 'string|nullable',
                'page' => 'integer|nullable',
                'page_size' => 'integer|between:1,100|nullable',
                'filter.start-date' => 'date|nullable',
                'filter.end-date' => 'date|nullable',
                'filter.area_uuid' => 'string|required'
            ]);
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        }
        $filter = $request->input('filter', []);
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        $query = Promotion::query()->with('areas');

        $query->whereHas('areas', function ($query) use ($filter) {
            if (isset($filter['area_uuid'])) {
                $query->where('areas.area_uuid', $filter['area_uuid']);
            }
        });
        $query->where(function (Builder $builder) use ($filter) {
            if (isset($filter['keyword'])) {
                $builder->where(function (Builder $builder) use ($filter) {
                    $keyword = $filter['keyword'];
                    $builder->orWhere('title', '%', $keyword, '%')
                        ->orWhere('promo_code', '%', $keyword, '%');
                });
            }

            if (isset($filter['start-date'])) {
                $builder->whereDate('promo_start', '>=', $filter['start-date']);
            }

            if (isset($filter['end-date'])) {
                $builder->whereDate('promo_end', '<=', $filter['end-date']);
            }
        });


        $promotion = PromotionResources::collection($query->paginate($pageSize, ['*'], 'page', $page));
        $pageInfo = $this->getPaginationDetails($promotion);
        return ApiResponse::success($promotion->items(), 200, 'success', $pageInfo);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePromotionRequest $request)
    {
        $promotion = promotion::create([
            'title' => $request->title,
            'promo_code' => $request->promo_code,
            'promo_start' => $request->promo_start,
            'promo_end' => $request->promo_end,
        ]);
        if ($request->image) {
            $uploadFolder = 'promo';
            $image_uploaded_path = $request->image->store($uploadFolder, 'public');
        }
        foreach ($request->area_uuids as $area) {
            AreaPromotion::create([
                'area_uuid' => $area,
                'promotion_uuid' => $promotion->promotion_uuid,
            ]);
        }

        return ApiResponse::success($promotion, 201, 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promotion = Promotion::with('areas')->find($id);
        if (!$promotion) {
            return ApiResponse::error(null, 404, 'Promo not found');
        }
        $resource = new PromotionResources($promotion);
        return ApiResponse::success($resource, 200, 'success');
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepromotionRequest $request, $id)
    {
        try {
            $promotion = Promotion::find($id);
            if (!$promotion) {
                return ApiResponse::error(null, 404, 'Promo not found');
            }
            $promotion->update([
                'title' => $request->title,
                'promo_code' => $request->promo_code,
                'promo_start' => $request->promo_start,
                'promo_end' => $request->promo_end,
                'status' => $request->status,
            ]);
            $promotion->areas()->detach();
            foreach ($request->area_uuids as $area) {
                AreaPromotion::create([
                    'promotion_uuid' => $promotion->promotion_uuid,
                    'area_uuid' => $area
                ]);
            }
            return ApiResponse::success($promotion, 201, 'Promotion Updated');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 401, 'Update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return ApiResponse::error(null, 404, 'Promo not found');
        }
        $promotion->delete();
        return ApiResponse::success($promotion, 200, 'Promo Deleted');
    }
}
