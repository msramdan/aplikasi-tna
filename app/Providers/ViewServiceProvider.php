<?php

namespace App\Providers;

use App\Models\Kota;
use App\Models\Lokasi;
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
        View::composer(['lokasi.create', 'lokasi.edit'], function ($view) {
            $data = Kota::select('id', 'nama_kota')->get();
            return $view->with(
                'kotas',
                $data
            );
        });

        View::composer(['ruang-kelas.create', 'ruang-kelas.edit', 'asrama.create', 'asrama.edit'], function ($view) {
            $data = Lokasi::select('id', 'nama_lokasi')->get();
            return $view->with(
                'lokasis',
                $data
            );
        });
    }
}
