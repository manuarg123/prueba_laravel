<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;
use App\Services\EntriesService;

class EntityController extends Controller
{
    protected $entriesService;

    public function __construct(EntriesService $entriesService)
    {
        $this->entriesService = $entriesService;
    }

    /**
     * Cuando ejecute el index de entities va a verificar que haya datos en entidades, cuando no haya , ejecutara el método para consumir la api de entradas donde busca y guarda entidades de esas categorias security y animals 
     */
    public function index()
    {
        $entities = Entity::all();

        //Solo lo ejecuta una vez para agregar las entradas de la api
        if ($entities->isEmpty()) {
            $this->entriesService->getAndSaveEntitiesFromApi();
            $entities = Entity::all();
        }
        
        return $entities;
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
