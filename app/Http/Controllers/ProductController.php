<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\{
    GetByIdRequest, SearchRequest
};

class ProductController extends Controller
{
    // Шаблон JSON ответа
    /**
     * Параметром принимает массив который надо выводить
     */
    private function sendResponce($responce = [])
    {
        return response()->json([
            'success' => $responce,
            'status' => true
        ], 200);
    }

    /**
     * Список всех продуктов
     */
    public function getList()
    {
        $responce = [
            'products' => Product::all()
        ];
        return $this->sendResponce($responce);
    }

    /**
     * Получае одного продукта по его ID
     */
    public function getProductById(GetByIdRequest $request)
    {
        $responce = [
            'products' => Product::find($request->id)
        ];
        return $this->sendResponce($responce);
    }

    /**
     * Функция поиска товара по названию, описанию, фармакологическому действию
     */
    public function getProductBySearch(SearchRequest $request)
    {
        $responce = [
            'products' => $this->search($request->search)
        ];
        return $this->sendResponce($responce);
    }

    // Функцию поиска
    private function search($q) {
        $query = mb_strtolower($q, 'UTF-8');
        $arr = explode(" ", $query);

        $query = [];
        foreach ($arr as $word) {
            $len = mb_strlen($word, 'UTF-8');
            switch (true) {
                case ($len <= 3): {
                    $query[] = $word . "*";
                    break;
                }
                case ($len > 3 && $len <= 6): {
                    $query[] = mb_substr($word, 0, -1, 'UTF-8') . "*";
                    break;
                }
                case ($len > 6 && $len <= 9): {
                    $query[] = mb_substr($word, 0, -2, 'UTF-8') . "*";
                    break;
                }
                case ($len > 9): {
                    $query[] = mb_substr($word, 0, -3, 'UTF-8') . "*";
                    break;
                }
                default: {
                    break;
                }
            }
        }
        $query = array_unique($query, SORT_STRING);
        $qQeury = implode(" ", $query);

        $results = Product::whereRaw(
            "MATCH(name, indications, pharmacological) AGAINST(? IN BOOLEAN MODE)",
            $qQeury)->get();

        return $results;
    }
}
