<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\ListPaket;

class ListPaketController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Paket';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ListPaket());

        //$grid->column('id', __('Id'));
        $grid->column('paket_id', __('Paketid'));
        $grid->column('quota', __('Quota'));
        $grid->column('desc', __('Keterangan'));
        $grid->column('harga', __('Harga'));
       // $grid->column('created_at', __('Created at'));
       // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(ListPaket::findOrFail($id));

        //$show->field('id', __('Id'));
        $show->field('paket_id', __('Paketid'));
        $show->field('quota', __('Quota'));
        $show->field('desc', __('Keterangan'));
        $show->field('harga', __('Harga'));
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
        $form = new Form(new ListPaket());

        $form->number('paket_id', __('Paketid'));
        $form->number('quota', __('Quota'));
        $form->text('desc', __('Keterangan'));
        $form->number('harga', __('Harga'));

        return $form;
    }
}
