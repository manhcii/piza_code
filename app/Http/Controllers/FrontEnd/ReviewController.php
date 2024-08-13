<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Exception;
use App\Consts;
use App\Models\Review;
use App\Models\CmsProduct;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'comment' => 'required|max:255'
            ]);

            $params = $request->except('_token', '_method');
            $params['status'] = Consts::STATUS['active'];
            $params['rating'] = $request->rating ?? 0;
            $insert = Review::insert($params);
            return redirect()->back()->with('successMessage', 'Gửi thành công');
        } catch (Exception $ex) {
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }
    public function showCompare(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);

            // $params = $request->except('_token', '_method');
            $params['id'] = $request->id;
            $lang = $request->lang;
            $row = CmsProduct::getsqlCmsProduct($params)->first();

            //check session
            $compare = [];
            if ($request->session()->has('compare')) {
                $compare = $request->session()->get('compare');
                if (count($compare) < 3) {
                    if (!collect($compare)->contains('id', $params['id'])) {
                        $compare[count($compare)] =  $row;
                    }
                }
            } else {
                $compare[0] = $row;
            }
            $request->session()->put('compare', $compare);

            // convert lang data show view
            $compares = [];
            // foreach ($compare as $key => $item) {
            //     $compares[$key]['id'] = $item->id;
            //     $compares[$key]['code'] = $item->json_params->code ?? " ";
            //     $compares[$key]['name'] = $item->json_params->name->$lang ?? $item->name;
            //     $compares[$key]['brief'] = $item->json_params->brief->$lang ?? $item->brief ?? "";
            //     $compares[$key]['content'] = $item->json_params->content->$lang ?? $item->content ?? "";
            //     $compares[$key]['price'] = $item->price ?? 0;
            //     $compares[$key]['price_old'] = $item->price_old ?? null;;
            //     $compares[$key]['rating'] = $item->rating ?? 0;
            //     $compares[$key]['image'] = $item->image ?? url('data/images/no_image.jpg');
            //     $compares[$key]['link'] = route('frontend.page', ['taxonomy' => $item->alias ?? '']);
            // }

            for ($i = 0; $i < 3; $i++) {
                if ($i >= count($compare)) {
                    $compares[$i] = null;
                } else {
                    $compares[$i]['id'] = $compare[$i]->id ?? "";
                    $compares[$i]['code'] = $compare[$i]->json_params->code ?? "";
                    $compares[$i]['name'] = $compare[$i]->json_params->name->$lang ?? $compare[$i]->name ?? "";
                    $compares[$i]['brief'] = $compare[$i]->json_params->brief->$lang ?? $compare[$i]->brief ?? "";
                    $compares[$i]['content'] = $compare[$i]->json_params->content->$lang ?? $compare[$i]->content ?? "";
                    $compares[$i]['price'] = $compare[$i]->price ?? 0;
                    $compares[$i]['price_old'] = $compare[$i]->price_old ?? null;
                    $compares[$i]['rating'] = $compare[$i]->rating ?? 0;
                    $compares[$i]['image'] = $compare[$i]->image ?? url('data/images/no_image.jpg');
                    $compares[$i]['link'] = route('frontend.page', ['taxonomy' => $compare[$i]->alias ?? '']);
                }
            }
            $messageResult = __('successfull!');
            return $this->sendResponse($compares, $messageResult);
        } catch (Exception $ex) {
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }
    public function deleteCompare(Request $request)
    {
        $key_del = $request['key'];
        $compare = $request->session()->get('compare');
        $data = [];
        foreach ($compare as $key => $val) {
            if ($key != $key_del) {
                $data[] = $val;
            }
        }
        $request->session()->put('compare', $data);
        $messageResult = __('successfull!');
        return $this->sendResponse($key, $messageResult);
    }
}
