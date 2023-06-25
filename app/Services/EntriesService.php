<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Entity;

class EntriesService
{
    public function getApiEntries()
    {
        $response = Http::get('https://api.publicapis.org/entries');

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Metodo para obtener la información de la api y persistirla en el modelo Entity según la categoría que corresponda obtenida de la api
     */
    public function getAndSaveEntitiesFromApi(){

        //Obtengo el json
        $response = $this->getApiEntries();
        if ($response) {
            $animalsCategoryId = Category::where('category', 'Animals')->value('id');
            $securityCategoryId = Category::where('category', 'Security')->value('id'); 

            $entities = $response['entries'];

            $entities_to_use = [];

            foreach ($entities as $entity) {
                if ($entity['Category'] == 'Animals' || $entity['Category'] == 'Security') {
                    $entities_to_use[] = $entity;
                }
            }

            foreach ($entities_to_use as $entity_to_use) {
                Entity::create([
                    'api' => $entity_to_use['API'],
                    'description' => $entity_to_use['Description'],
                    'link' => $entity_to_use['Link'],
                    'category_id' => $entity_to_use['Category'] === 'Animals' ? $animalsCategoryId : $securityCategoryId,
                ]);
            }
        }
    }
}