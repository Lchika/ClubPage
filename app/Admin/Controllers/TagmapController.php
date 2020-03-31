<?php

namespace App\Admin\Controllers;

use App\Tagmap;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TagmapController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Tagmap';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tagmap());

        $grid->column('id', __('Id'));
        $grid->column('post_id', __('Post id'));
        $grid->column('tag_id', __('Tag id'));
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
        $show = new Show(Tagmap::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('post_id', __('Post id'));
        $show->field('tag_id', __('Tag id'));
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
        $form = new Form(new Tagmap());

        $form->text('post_id', __('Post id'));
        $form->number('tag_id', __('Tag id'));

        return $form;
    }
}