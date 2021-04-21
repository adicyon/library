<?php

namespace Apply\Library\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if (! defined('LIBRARY_PATH')) {
      define('LIBRARY_PATH', realpath(__DIR__.'/../../'));
    }

    $this->mergeConfigFrom(realpath(LIBRARY_PATH . '/config/library.php'), 'library');
      $this->mergeConfigFrom(realpath(LIBRARY_PATH . '/config/plugin.php'), 'libraries.plugin');
      $this->mergeConfigFrom(realpath(LIBRARY_PATH . '/config/module.php'), 'libraries.module');
    $this->mergeConfigFrom(realpath(LIBRARY_PATH . '/config/collect.php'), 'libraries.collect');

   // $this->app->register(LibraryServiceProvider::class);
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
      //
  }
}
