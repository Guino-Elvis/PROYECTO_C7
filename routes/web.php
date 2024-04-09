<?php

use App\Http\Livewire\AccountSettingProfile;
use App\Http\Livewire\AccountSettingYape;
//use App\Http\Livewire\SisCrudEmpresa;
use App\Http\Livewire\DashboardGeneral;
use App\Http\Livewire\PageBolsaLaboral;
use App\Http\Livewire\SecurityPermissions;
use App\Http\Livewire\SecurityRoles;
use App\Http\Livewire\SisCrudEmpresa;
use App\Http\Livewire\SisCrudOfertaLaboral;
use App\Http\Livewire\TableCategories;
use App\Http\Livewire\TableProducts;
use App\Http\Livewire\TableUsers;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        // Route::get('/', function () {
        //     return view('welcome');
        // })->name('/');



        Route::get('/', PageBolsaLaboral::class)->name('inicio');
        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified'
        ])->group(function () {
            Route::get('/sistema/pagina/dashboard-general', DashboardGeneral::class)->name('dashboard-general');
            Route::get('/sistema/pagina/dashboard-ventas', DashboardGeneral::class)->name('dashboard-ventas');

            Route::get('/sistema/pagina/configurar-cuenta-perfil', AccountSettingProfile::class)->name('configurar-cuenta-perfil');
            Route::get('/sistema/pagina/configurar-cuenta-yape', AccountSettingYape::class)->name('configurar-cuenta-yape');

            Route::get('/sistema/pagina/seguridad-roles', SecurityRoles::class)->name('seguridad-roles');
            Route::get('/sistema/pagina/seguridad-permisos', SecurityPermissions::class)->name('seguridad-permisos');
            Route::get('/sistema/pagina/favoritos', AccountSettingProfile::class)->name('favoritos');
            Route::get('/sistema/pagina/mensajes', AccountSettingProfile::class)->name('mensajes');

            Route::get('/sistema/pagina/tabla-usuarios', TableUsers::class)->name('tabla-usuarios');
            Route::get('/sistema/pagina/tabla-categorias', TableCategories::class)->name('tabla-categorias');
            Route::get('/sistema/pagina/tabla-productos', TableProducts::class)->name('tabla-productos');
            Route::get('/sistema/pagina/tabla-empresas', SisCrudEmpresa::class)->name('tabla-empresas');
            Route::Resource('empresa',SisCrudEmpresa::class);

            Route::get('/sistema/pagina/tabla-ofertas-laborales', SisCrudOfertaLaboral::class)->name('tabla-ofertas-laborales');
            Route::Resource('oferta_laboral',SisCrudOfertaLaboral::class);

            Route::get('/sistema/pagina/tabla-banners', AccountSettingProfile::class)->name('tabla-banners');

            Route::get('/sistema/pagina/tabla-venta-clientes', AccountSettingProfile::class)->name('tabla-venta-clientes');
            Route::get('/sistema/pagina/tabla-venta-entregas', AccountSettingProfile::class)->name('tabla-venta-entregas');
            Route::get('/sistema/pagina/registro-de-ventas-listado-de-ventas', AccountSettingProfile::class)->name('registro-de-ventas');
            Route::get('/sistema/pagina/registro-de-ventas-pagos-yape', AccountSettingProfile::class)->name('registro-de-ventas-pagos-yape');
            Route::get('/sistema/pagina/registro-de-ventas-productos-vendidos', AccountSettingProfile::class)->name('registro-de-ventas-productos-vendidos');

            Route::get('/sistema/pagina/registro-de-compras-listado-de-compras', AccountSettingProfile::class)->name('registro-de-compras');
            Route::get('/sistema/pagina/registro-de-compras-pagos-yape', AccountSettingProfile::class)->name('registro-de-compras-pagos-yape');
            Route::get('/sistema/pagina/registro-de-compras-productos-comprados', AccountSettingProfile::class)->name('registro-de-compras-productos-comprados');

            // REPORTES
            Route::get('/empresas/pdf', [SisCrudEmpresa::class, 'createPDF']);
            Route::get('/empresas/csv', [SisCrudEmpresa::class, 'createCSV']);
            Route::get('/empresas/excel', [SisCrudEmpresa::class, 'createEXCEL']);
            Route::get('/ofertas_laborales/pdf', [SisCrudOfertaLaboral::class, 'createPDF']);
            Route::get('/ofertas_laborales/csv', [SisCrudOfertaLaboral::class, 'createCSV']);
            Route::get('/ofertas_laborales/excel', [SisCrudOfertaLaboral::class, 'createEXCEL']);



        });
    });


require_once __DIR__ . '/jetstream.php';
require_once __DIR__ . '/fortify.php';
