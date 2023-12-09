<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\ListPosition;
use \App\Models\User;

class ListPositionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ListPosition';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ListPosition());

       // $grid->column('id', __('Id'));
        $grid->column('user.nama', __('Nama'));
        $grid->column('parent.nama', __('Atasan'));
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
        $show = new Show(ListPosition::findOrFail($id));

       // $show->field('id', __('Id'));
        $show->field('user.nama', __('Nama'));
        $show->field('parent.nama', __('Atasan'));
        $show->field('created_at', __('Created at'));
       // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ListPosition());

        $form->select('user_id', __('Nama'))->options(User::all()->pluck('nama','id'))->required();

        //$form->number('user_id', __('User id'));
        $form->select('parent_id', __('Atasan'))->options(User::all()->pluck('nama','id'))->required();;

        return $form;
    }
}
