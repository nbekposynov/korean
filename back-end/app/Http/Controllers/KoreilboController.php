<?php

namespace App\Http\Controllers;
use App\Models\Koreilbo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KoreilboController extends Controller
{
    public function index()
    {
        $koreilbos = Koreilbo::paginate(7);

        // Проходим через каждый элемент пагинации для обновления информации об изображении
        $koreilbos->getCollection()->transform(function ($koreilbo) {
            if ($koreilbo->image) {
                $image = json_decode($koreilbo->image, true);
                if (is_array($image) && count($image) > 0) {
                    // Предполагаем, что $image[0] содержит нужный элемент 'download_link'
                    $koreilbo->image = json_encode($image);

                    $koreilbo->image = url('/storage/' . str_replace('\\', '/', $image[0]['download_link']));

                }
            }
            return $koreilbo;
        });

        return response()->json($koreilbos);
    }

    public function show($id)
    {
        $koreilbo = Koreilbo::find($id);

        if (!$koreilbo) {
            return response()->json(['message' => 'Not Found!'], Response::HTTP_NOT_FOUND);
        }

        if ($koreilbo->image) {
            $image = json_decode($koreilbo->image, true);
            if (is_array($image) && count($image) > 0) {
                $koreilbo->image = json_encode($image);
                $koreilbo->image = url('/storage/' . str_replace('\\', '/', $image[0]['download_link']));
            }
        }

        return response()->json($koreilbo);
    }
}
