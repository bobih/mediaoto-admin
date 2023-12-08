<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Auth\Permission;
use OpenAdmin\Admin\Facades\Admin;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Controllers\BrandController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;
use \App\Models\Paket;
use \App\Models\Brands;
use \App\Models\Province;
use \App\Models\City;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
       
        

        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('nama', __('Nama'))->ucfirst();
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        $grid->column('quota', __('Quota'));
        $grid->column('brands.brand', __('Brand'));


        // Filter
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('nama', 'nama');
        });

       
        /*
        if (!Admin::user()->can('delete-content')) {
            $actions->disableDelete();
        }

        if (Admin::user()->isAdministrator()) {
            $grid->disableDelete();
        }
        */

        $grid->actions(function ($actions) {
            //if (Admin::user()->isAdministrator()) {
                $actions->disableDelete();
           // }

            //$actions->disableDelete();
           // $actions->disableEdit();
           // $actions->disableView();
        });


        return $grid;
	
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

       // $show->field('id', __('Id'));
        $show->field('nama', __('Nama'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('quota', __('Quota'));
        $show->field('alamat', __('Alamat'));
        $show->field('province.name', __('Provinsi'));
        $show->field('city.name', __('Kota'))->as(function($city){
            return ucwords(strtolower($city));
        });
        $show->field('brands.brand', __('Brand'));
	

        $show->prospek('Prospek information', function ($prospek) {
                $prospek->setResource('/admin/prospeks');
                $prospek->column('lead.name', __('Nama'));
                $prospek->column('lead.model', __('Model'));
                $prospek->column('lead.variant', __('Variant'));
                $prospek->note();

                $prospek->actions(function ($actions) {
                    $actions->disableDelete();
                    //$actions->disableDelete();
                    $actions->disableEdit();
                    //$actions->disableView();
                   
                });
                $prospek->disableCreateButton();

        });


        $show->field('created_at', __('Created at'));

        $show->panel()->tools(function ($tools) {
            //$tools->disableEdit();
            //$tools->disableList();
            $tools->disableDelete();
        });

       

	//dd($show);

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('nama', __('Nama'))->required();
        $form->email('email', __('Email'))->required();
        $form->text('phone', __('Phone'));
       	$form->text('quota', __('Quota'))->default(100)->required();
       	$form->select('brand_id', __('Brand'))->options(Brands::all()->pluck('brand','id'))->required();
	    $form->textarea('alamat', __('Alamat'));
        $form->image('image', __('Avatar'));
        $form->image('ktp', __('KTP'));
        $form->image('npwp', __('NPWP'));

        $form->select('province_id', __('Provinsi'))
            ->options(Province::all()
            ->pluck('name','id'))
            ->load('city_id', '/api/city');
        $form->select('city_id', __('Kota'))->options(City::all()
            ->pluck('name','id'));


        $form->tools(function (Form\Tools $tools) {

            // Disable `List` btn.
            // $tools->disableList();
        
            // Disable `Delete` btn.
            $tools->disableDelete();
        
            // Disable `Veiw` btn.
            // $tools->disableView();
        
            // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
            // $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
        });

        return $form;
    }


}
