<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AlbumRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AlbumCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AlbumCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Album::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/album');
        CRUD::setEntityNameStrings('album', 'albums');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('slug');
        CRUD::column('cover');
        CRUD::column('length');
        CRUD::column('release');
        CRUD::addColumn([
            'name' => 'artist_id',
            'label' => 'Artiste',
            'type' => 'closure',
            'orderable' => true,
            'escaped'   => false,
            'function'  => function($entry) {
                $artist = \App\Models\Artist::find($entry->artist_id);
                return ($entry->artist_id) ? '<a href="' . backpack_url('artist', $entry->artist_id) . '/show">' . $artist->name. '</a>' : '<small>N/A</small>';
            },
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();

        $this->crud->setShowView('album.crud.show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('name');
        // CRUD::field('length');
        CRUD::field('release');
        CRUD::addField([
            'name' => 'cover',
            'label' => 'Cover',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public', // Remplacez "public" par le nom de votre disque de stockage approprié
            'validationRules' => 'mimetypes:image/jpeg,image/png', // Règle de validation pour les fichiers image
            'validationMessages' => [
                'mimetypes' => 'Le fichier doit être au format image (JPG, PNG, JPEG).',
            ]
        ]);
        CRUD::addField([
            'name' => 'artist_id',
            'label' => 'Artist',
            'type' => 'select',
            'entity' => 'artists', // Remplacez "style" par le nom de votre entité liée
            'attribute' => 'name', // Remplacez "name" par l'attribut que vous souhaitez afficher dans le champ select
            'model' => "App\Models\Artist" // Remplacez "App\Models\Style" par le modèle correspondant à votre entité liée
        ]);
        // CRUD::addField([
        //     'name' => 'artist_id',
        //     'label' => 'Artiste',
        //     'type' => 'select',
        //     'entity' => 'artists', // Remplacez "style" par le nom de votre entité liée
        //     'attribute' => 'name', // Remplacez "name" par l'attribut que vous souhaitez afficher dans le champ select
        //     'model' => "App\Models\Artist", // Remplacez "App\Models\Style" par le modèle correspondant à votre entité liée
        //     'options' => [
        //         'order' => ['name', 'asc'], // Tri par le nom dans l'ordre croissant
        //     ],
        // ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
