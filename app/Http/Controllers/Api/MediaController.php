<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

class MediaController extends Controller
{
    public function uploadImage(Request $request, $folder)
    {
        $response = Helper::apiFormat();

        $rule = [
            'images.*' => 'required|image',
        ];

        $validator = \Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return \Response::json($response, $response['status']);
        }

        $folder = str_slug($folder);
        $prefix_path = 'uploads/' . join('/', explode('-', $folder));

        $images = is_array($request->file('images')) ? $request->file('images') : [];
        $dataRespone = [];
        foreach ($images as $image) {
            if (!$image) {
                continue;
            }
            $image->hashName();
            $path = $image->store($prefix_path, 'uploads');
            $data['path_origin'] = $path;
            $dataRespone[] = url($path);
        }
        $response['data'] = $dataRespone;
        $response['message'][] = __('Upload image successfully!');

        return \Response::json($response, $response['status']);
    }
}
