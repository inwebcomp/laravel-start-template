<?php

namespace App\Admin\Resources;

use Admin\ResourceTools\Images\Images;
use App\Admin\Actions\Hide;
use App\Admin\Actions\Publish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use InWeb\Admin\App\Fields\Boolean;
use InWeb\Admin\App\Fields\Date;
use InWeb\Admin\App\Fields\Editor;
use InWeb\Admin\App\Fields\Password;
use InWeb\Admin\App\Fields\PasswordConfirmation;
use InWeb\Admin\App\Fields\Text;
use InWeb\Admin\App\Http\Requests\AdminRequest;
use InWeb\Admin\App\Resources\Resource;

class AdminUser extends Resource
{
    public static    $model    = \InWeb\Admin\App\Models\AdminUser::class;
    protected static $position = 11;

    public static $globallySearchable = false;

    public static $search = [
        'email', 'login'
    ];

    public function title()
    {
        return $this->login;
    }

    public static function label()
    {
        return __('Пользователи');
    }

    public static function singularLabel()
    {
        return __('Пользователь');
    }

    public static function uriKey()
    {
        return 'admin-user';
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
            Text::make(__('Логин'), 'login')->link($this->editPath()),
            Text::make(__('Email'), 'email'),
            Date::make(__('Дата регистрации'), 'created_at'),
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
        $id = $request->findModelOrFail()->id;

        return [
            Text::make(__('Логин'), 'login')
                ->rules(['required', Rule::unique('admin_users')->ignore($id)]),
            Text::make(__('Email'), 'email')
                ->rules(['required', Rule::unique('admin_users')->ignore($id)]),

            Password::make(__('Пароль'), 'password')->rules(['nullable']),
            PasswordConfirmation::make(__('Повторите пароль'), 'password_confirm')->rules(['same:password']),
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
            Text::make(__('Логин'), 'login')
                ->rules(['required', 'unique:admin_users']),
            Text::make(__('Email'), 'email')
                ->rules(['required', 'unique:admin_users']),

            Password::make(__('Пароль'), 'password')->rules(['required']),
            PasswordConfirmation::make(__('Повторите пароль'), 'password_confirm')->rules(['required', 'same:password']),
        ];
    }
}
