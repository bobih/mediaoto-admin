<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Prospek;
use \App\Models\Lead;


class ProspekController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Prospek';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Prospek());

       // $grid->column('id', __('Id'));
       // $grid->column('userid', __('Userid'));
       // $grid->column('leadsid', __('Leadsid'));
        $grid->column('lead.name', __('Nama'));
        $grid->column('view', __('View'));
        $grid->column('favorite', __('Favorite'));
        $grid->column('note', __('Note'));
        $grid->column('lost', __('Lost'));
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
        $show = new Show(Prospek::findOrFail($id));

        //$show->field('id', __('Id'));
        //$show->field('userid', __('Userid'));
        //$show->field('leadsid', __('Leadsid'));
        $show->field('lead.name', __('Nama'));
        $show->field('lead.phone', __('Phone'));
        $show->field('lead.model', __('Model'));
        $show->field('lead.variant', __('Variant'));
        $show->field('view', __('View'));
        $show->field('favorite', __('Favorite'));
        $show->field('note', __('Catatan'));
        $show->field('lost', __('Lost'));
        //$show->field('created_at', __('Created at'));
        //$show->field('updated_at', __('Updated at'));

        $show->panel()->tools(function ($tools) {
            //$tools->disableEdit();
            //$tools->disableList();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Prospek());

        $form->number('userid', __('Userid'));
        $form->number('leadsid', __('Leadsid'));
        $form->switch('view', __('View'));
        $form->switch('favorite', __('Favorite'));
        $form->textarea('note', __('Note'));
        $form->switch('lost', __('Lost'));

        return $form;
    }
}
