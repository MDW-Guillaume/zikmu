<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArtistRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArtistCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArtistCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Artist::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/artist');
        CRUD::setEntityNameStrings('artist', 'artists');
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
        CRUD::column('follow');
        // CRUD::column('style_id');  // Besoin de récupérer le nom du style
        // CRUD::addColumn([
        //     'name' => 'style_id',
        //     'label' => 'Style',
        //     'type' => 'select',
        //     'entity' => 'styles', // Nom de l'entité dans la base de données (tableau styles)
        //     'attribute' => 'name', // Attribut à afficher (nom du style)
        //     'model' => "App\Models\Style" // Modèle correspondant à l'entité style
        // ]);
        CRUD::addColumn([
            'name' => 'style_id',
            'label' => 'Style',
            'type' => 'closure',
            'orderable' => true,
            'escaped'   => false,
            'function'  => function($entry) {
                // dd($entry); die;
                $style = \App\Models\Style::find($entry->style_id);
                return ($entry->style_id) ? '<a href="' . backpack_url('style', $entry->style_id) . '/show">' . $style->name. '</a>' : '<small>N/A</small>';
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

        $this->crud->setShowView('artist.crud.show');
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
        // CRUD::field('follow');
        // CRUD::field('cover');
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
        // CRUD::field('style_id');
        CRUD::addField([
            'name' => 'style_id',
            'label' => 'Style',
            'type' => 'select',
            'entity' => 'styles', // Remplacez "style" par le nom de votre entité liée
            'attribute' => 'name', // Remplacez "name" par l'attribut que vous souhaitez afficher dans le champ select
            'model' => "App\Models\Style" // Remplacez "App\Models\Style" par le modèle correspondant à votre entité liée
        ]);
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
