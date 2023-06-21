<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('email');
        CRUD::column('firstname');
        CRUD::column('lastname');
        CRUD::column('created_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::field('email');
        CRUD::addField([
            'name' => 'email',
            'label' => 'E-mail',
            'type' => 'email',
            'validationRules' => 'required',
            'validationMessages' => [
                'required' => 'Vous devez renseigner un email.',
            ]

        ]);
        CRUD::field('firstname');
        CRUD::field('lastname');
        CRUD::addField([
            'name' => 'is_admin',
            'label' => 'Définir en tant qu\'administrateur ?',
            'type' => 'checkbox',
        ]);
        // CRUD::addField([
        //     'name' => 'creation',
        //     'label' => '',
        //     'type' => 'hidden',
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
        CRUD::addField([
            'name' => 'password',
            'label' => 'Mot de passe',
            'type' => 'password',
            'default' => '',
            'suffix' => '<span toggle="#password" class="la la-fw la-sync field-icon generate-password"></span></span><span class="input-group-text"><span toggle="#password" class="la la-fw la-eye field-icon toggle-password"></span>',
            'attributes' => [
                'id' => 'password',
                'class' => 'form-control',
            ],
        ]);
        CRUD::field('firstname');
        CRUD::field('lastname');
        CRUD::addField([
            'name' => 'is_admin',
            'label' => 'Définir en tant qu\'administrateur ?',
            'type' => 'checkbox',
        ]);
    }
}
