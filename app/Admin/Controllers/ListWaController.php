<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\ListWa;

class ListWaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ListWa';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ListWa());

        $grid->column('id', __('Id'));
        $grid->column('userid', __('Userid'));
        $grid->column('leadsid', __('Leadsid'));
        $grid->column('tanggal', __('Tanggal'));
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
        $show = new Show(ListWa::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('userid', __('Userid'));
        $show->field('leadsid', __('Leadsid'));
        $show->field('tanggal', __('Tanggal'));
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
        $form = new Form(new ListWa());

        $form->number('userid', __('Userid'));
        $form->number('leadsid', __('Leadsid'));
        $form->datetime('tanggal', __('Tanggal'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
