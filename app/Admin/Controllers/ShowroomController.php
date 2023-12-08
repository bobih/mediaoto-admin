<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Controllers\BrandController;
use OpenAdmin\Admin\Controllers\ProvinceController;

use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Showroom;
use \App\Models\Brands;
use \App\Models\Province;
use \App\Models\City;

class ShowroomController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Showroom';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Showroom());
        $grid->column('showroom', __('Showroom'));            
        $grid->column('city.name', __('City'))
                ->display(function($city) {
                    return ucwords(strtolower($city));
                });
        $grid->column('brands.brand', __('Brand'));
   
	    $grid->filter(function($filter){
            $filter->disableIdFilter();
            // Add a column filter
            $filter->like('showroom', 'showroom');
            $filter->like('brands.brand', 'brand');
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
        $show = new Show(Showroom::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('showroom', __('Showroom'));
        $show->field('alamat', __('Alamat'));
       // $show->field('province.name', __('Province'));
       // $show->field('city.name', __('City'));
        $show->field('brands.brand', __('Brand'));
      //  $show->field('created_at', __('Created at'));
      //  $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Showroom());

        $form->text('showroom', __('Showroom'));
        $form->textarea('alamat', __('Alamat'));
        $form->select('brand_id',__('Brand'))->options(Brands::all()->pluck('brand','id'));
        //$form->text('city', __('City'));
        //$form->number('brand', __('Brand'));
	//$form->select('brand', __('Brand'))->options(Brands::all()->pluck('brand','id'))->required();
	$form->select('province_id',__('Provinsi'))->options(Province::all()->pluck('name','id'))->load('city_id', '/api/city');
	$form->select('city_id',__('Kota'))->options(City::all()->pluck('name','id'));

        return $form;
    }
}
