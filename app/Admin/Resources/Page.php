<?php

namespace App\Admin\Resources;

use Admin\ResourceTools\Metadata\Metadata;
use App\Admin\Actions\Hide;
use App\Admin\Actions\Publish;
use Illuminate\Http\Request;
use InWeb\Admin\App\Fields\Boolean;
use InWeb\Admin\App\Fields\Editor;
use InWeb\Admin\App\Fields\Text;
use InWeb\Admin\App\Http\Requests\AdminRequest;
use InWeb\Admin\App\Resources\Resource;

class Page extends Resource
{
    public static $model = \App\Models\Page::class;

    protected static $position = 3;

    public static function label()
    {
        return __('Страницы');
    }

    public static function singularLabel()
    {
        return __('Страница');
    }

    public static function uriKey()
    {
        return 'page';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param AdminRequest $request
     * @return array
     */
    public function fields(AdminRequest $request)
    {
        return [
            Text::make(__('Название'), 'title')->link($this->editPath()),
            Text::make(__('URL ID'), 'slug'),
            Boolean::make('Published', 'status'),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param AdminRequest $request
     * @return array
     */
    public function creationFields(AdminRequest $request)
    {
        return [
            Text::make(__('Название'), 'title')->rules('required'),
            Text::make(__('URL ID'), 'slug'),
            Editor::make(__('Текст'), 'text'),
            Boolean::make('Published', 'status')->default(true),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param AdminRequest $request
     * @return array
     */
    public function detailFields(AdminRequest $request)
    {
        return [
            Text::make(__('Название'), 'title')->rules('required'),
            Text::make(__('URL ID'), 'slug'),
            Editor::make(__('Текст'), 'text'),
            Boolean::make('Published', 'status')->default(true),

            new Metadata(),
        ];
    }

    public function actions(Request $request)
    {
        return [
            new Publish(),
            new Hide(),
        ];
    }
}
