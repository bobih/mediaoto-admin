<?php

namespace App\Admin\Controllers;

use App\Models\ListPaket;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Invoice;
use \App\Models\User;

use Admin;

class InvoiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Invoice';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Invoice());

        $grid->column('id', __('Id'));
        $grid->column('username.nama', __('Nama'));
        $grid->column('paketname.name', __('Paket'));
        $grid->column('status', __('Status'));
        $grid->column('tanggal', __('Tanggal'));
        $grid->column('createdname.nama', __('Createdby'));
       // $grid->column('approved', __('Approved'));
       // $grid->column('created_at', __('Created at'));
       // $grid->column('updated_at', __('Updated at'));

        /*
        $show->field('id', __('Id'));
        $show->field('username.nama', __('Nama'));

        $show->field('paketname.name', __('Paket'));
        $show->field('status', __('Status'));
        $show->field('tanggal', __('Tanggal'));
        $show->field('createdname.nama', __('Createdby'));
        $show->field('approvedname.nama', __('Approved'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        */

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
        $show = new Show(Invoice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username.nama', __('Nama'));

        $show->field('paketname.name', __('Paket'));
        $show->field('status', __('Status'));
        $show->field('tanggal', __('Tanggal'));
        $show->field('createdname.nama', __('Createdby'));
        $show->field('approvedname.nama', __('Approved'));
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
        $form = new Form(new Invoice());

        //$form->number('userid', __('Userid'));
        $form->select('userid', __('Nama'))->options(User::all()->pluck('nama', 'id'))->required();
        $form->select('paketid', __('Paket'))->options(ListPaket::all()->pluck('name', 'id'))->required();

        //$form->number('paketid', __('Paketid'));

        $form->switch('status', __('Status'));
        $form->datetime('tanggal', __('Tanggal'))->default(date('Y-m-d H:i:s'));
        $form->select('createdby', __('Created'))->options(User::all()->pluck('nama', 'id'))->required();
        //$form->number('approved', __('Approved'));

       // $form->text('createdby', __('Nama'))->options(User::find(Admin::user()->id)->pluck('nama', 'id'));

        return $form;
    }
}
