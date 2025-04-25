<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!Type::hasType('enum')) {
            // Регистрируем enum тип
            Type::addType('enum', 'Doctrine\DBAL\Types\StringType');

            // Получаем платформу и маркируем тип как комментируемый
            $platform = $this->app['db']->getDoctrineConnection()->getDatabasePlatform();
            $platform->markDoctrineTypeCommented(Type::getType('enum'));
        }
    }
}
