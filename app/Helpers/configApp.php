<?php

use App\ConfigApp;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

function getConfig($route)
{
    $config = [];

    $components = DB::table('components')
        ->join('menu', 'components.id_menu', '=', 'menu.id')
        ->select('components.*')
        ->where('menu.route', '=', $route)
        ->get();

    if (isset($components)) {
        foreach ($components as $component) {
            $config[strtolower($component->name)] = toArrayConfig(stringConvert(ConfigApp::select('name', 'type', 'values')->where('id_component', '=', $component->id)->get()));
        }
    }

    // getLang
    $config['lang'] = translations(
        resource_path('lang/' . App::getLocale() . '.json'),
        $route
    );

    return $config;
}
