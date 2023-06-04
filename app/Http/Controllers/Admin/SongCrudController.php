<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SongRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Validator;
/**
 * Class SongCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SongCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Song::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/song');
        CRUD::setEntityNameStrings('song', 'songs');
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
        CRUD::column('length');
        CRUD::column('position');
        CRUD::addColumn([
            'name' => 'album_id',
            'label' => 'Album',
            'type' => 'closure',
            'orderable' => true,
            'escaped'   => false,
            'function'  => function ($entry) {
                // dd($entry); die;
                $album = \App\Models\Album::find($entry->album_id);
                return ($entry->album_id) ? '<a href="' . backpack_url('album', $entry->album_id) . '/show">' . $album->name . '</a>' : '<small>N/A</small>';
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

        $this->crud->setShowView('song.crud.show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::field('name')->attributes(['required' => 'required']);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Nom',
            'type' => 'text',
            'validationRules' => 'required',
            'validationMessages' => [
                'required' => 'Vous devez renseigner un nom pour le titre',
            ]
        ]);
        CRUD::addField([
            'name' => 'song_file',
            'label' => 'Fichier',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
            // 'validationRules' => 'required',
            'validationRules' => 'required|mimetypes:audio/mpeg,audio/x-wav,audio/mp3', // Règle de validation pour les fichiers audio
            'validationMessages' => [
                'required' => 'Vous devez ajouter un fichier audio',
                'mimetypes' => 'Le fichier doit être au format audio (MP3, WAV, etc.).',
            ]
        ]);
        CRUD::addField([
            'name' => 'album_id',
            'label' => 'Album',
            'type' => 'select',
            'entity' => 'albums', // Remplacez "style" par le nom de votre entité liée
            'attribute' => 'name', // Remplacez "name" par l'attribut que vous souhaitez afficher dans le champ select
            'model' => "App\Models\Album" // Remplacez "App\Models\Style" par le modèle correspondant à votre entité liée
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
        CRUD::addField([
            'name' => 'name',
            'label' => 'Nom',
            'type' => 'text',
            'validationRules' => 'required',
            'validationMessages' => [
                'required' => 'Vous devez renseigner un nom pour le titre',
            ]
        ]);

        CRUD::addField([
            'name' => 'song_file',
            'label' => 'Fichier',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
            // 'validationRules' => 'required',
            'validationRules' => 'required|mimetypes:audio/mpeg,audio/x-wav,audio/mp3', // Règle de validation pour les fichiers audio
            'validationMessages' => [
                'required' => 'Vous devez ajouter un fichier audio',
                'mimetypes' => 'Le fichier doit être au format audio (MP3, WAV, etc.).',
            ]
        ]);

        // CRUD::addField([
        //     'name' => 'position',
        //     'label' => 'Position',
        //     'type' => 'number',
        // ]);

        // CRUD::addField([
        //     'name' => 'album_id',
        //     'label' => 'Album',
        //     'type' => 'select',
        //     'entity' => 'albums', // Remplacez "style" par le nom de votre entité liée
        //     'attribute' => 'name', // Remplacez "name" par l'attribut que vous souhaitez afficher dans le champ select
        //     'model' => "App\Models\Album" // Remplacez "App\Models\Style" par le modèle correspondant à votre entité liée
        // ]);
    }
}
