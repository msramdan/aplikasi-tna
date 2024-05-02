<?php

namespace App\Providers;

use App\Models\Campus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['users.create', 'users.edit'], function ($view) {
            $data = Role::select('id', 'name')->get();
            return $view->with(
                'roles',
                $data
            );
        });
        View::composer(['ruang-kelas.create', 'ruang-kelas.edit'], function ($view) {
            $data = Campus::select('id', 'nama_kampus')->get();
            return $view->with(
                'campuses',
                $data
            );
        });

        View::composer(['asrama.create', 'asrama.edit'], function ($view) {
            $data = Campus::select('id', 'nama_kampus')->get();
            return $view->with(
                'campuses',
                $data
            );
        });

    }
}
