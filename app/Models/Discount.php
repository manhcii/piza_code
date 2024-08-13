<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Consts;

class Discount extends Model
{
    protected $table = 'tb_discounts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'json_params' => 'object',
    ];

    public static function getsqlDiscount($params, $isPaginate = false)
    {

        // dd($params);
        $query = Discount::selectRaw('tb_discounts.*')
            ->when(!empty($params['keyword']), function ($query) use ($params) {
                $keyword = $params['keyword'];
                return $query->where(function ($where) use ($keyword) {
                    return $where->where('tb_discounts.name', 'like', '%' . $keyword . '%')
                        ->orWhere('tb_discounts.json_params->title->vi', 'like', '%' . $keyword . '%');
                });
            })

            ->when(!empty($params['id']), function ($query) use ($params) {
                return $query->where('tb_discounts.id', $params['id']);
            });

       
        if (!empty($params['status'])) {
            $query->where('tb_discounts.status', $params['status']);
        } else {
            $query->where('tb_discounts.status', "!=", Consts::STATUS_DELETE);
        }

        // Check with order_by params
        if (!empty($params[''])) {
            if (is_array($params['order_by'])) {
                foreach ($params['order_by'] as $key => $value) {
                    $query->orderBy('tb_discounts.' . $key, $value);
                }
            } else {
                $query->orderByRaw('tb_discounts.' . $params['order_by'] . ' desc');
            }
        } else {
            $query->orderByRaw('tb_discounts.id DESC');
        }
        $query->groupBy('tb_discounts.id');
        return $query;
    }
}
