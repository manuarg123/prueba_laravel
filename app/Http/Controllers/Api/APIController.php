<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Category;

class APIController extends Controller
{
    /**
     * Este index puede recibir $category como parametro, ya sea Animals o Security, para mostrar las entidades correspondientes a estas categorias en el return
     */
    public function index($category)
    {
        //Solo si se ingresan estas categorias hace el return correspondiente
        if ($category == 'Animals' || $category == 'Security') {
            switch ($category) {
                case 'Animals':
                    $category_id = Category::where('category', 'Animals')->value('id');
                    break;

                case 'Security':
                    $category_id = Category::where('category', 'Security')->value('id'); 
                    break;

                default:
                    return response()->json([
                        'error' => true,
                        'message' => 'Ingrese las categorias permitidas',
                    ]);
                    break;
            }

            //Obtengo según la categoria las entidades correspondientes y mapeo en array para mostrar en el response
            $data = Entity::select('api', 'description', 'link', 'category_id')
            ->where('category_id', $category_id)
            ->get()
            ->map(function ($item) {
                return [
                    'api' => $item->api,
                    'description' => $item->description,
                    'link' => $item->link,
                    'category' => [
                        'id' => $item->category_id,
                        'category' => Category::where('id', $item->category_id)->value('category'),
                    ],
                ];
            })
            ->toArray();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Ingrese las categorias permitidas',
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
