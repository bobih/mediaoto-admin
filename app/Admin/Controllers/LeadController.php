<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Lead;

class LeadController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Lead';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Lead());

        $grid->column('id', __('Id'));
        $grid->column('create', __('Create'));
        $grid->column('name', __('Name'));
        $grid->column('phone', __('Phone'));
        $grid->column('brand', __('Brand'));
        $grid->column('variant', __('Variant'));
        $grid->column('city', __('City'));
        $grid->column('lokasi', __('Lokasi'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Lead::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('create', __('Create'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('brand', __('Brand'));
        $show->field('variant', __('Variant'));
        $show->field('city', __('City'));
        $show->field('lokasi', __('Lokasi'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Lead());

        $form->datetime('create', __('Create'))->default(date('Y-m-d H:i:s'));
        $form->text('name', __('Name'));
        $form->phonenumber('phone', __('Phone'));
        $form->number('brand', __('Brand'));
        $form->text('variant', __('Variant'));
        $form->text('city', __('City'));
        $form->text('lokasi', __('Lokasi'));

        return $form;
    }
}
