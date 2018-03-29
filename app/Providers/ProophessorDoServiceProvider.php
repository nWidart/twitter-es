<?php

declare(strict_types=1);

namespace App\Providers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;

class ProophessorDoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Connection::class, function () {
            $default = config('database.default');

            switch ($default) {
                case 'mysql':
                    $driver = 'pdo_mysql';
                    break;
                case 'postgres':
                    $driver = 'pdo_pgsql';
            }

            return DriverManager::getConnection([
                'dbname'   => config(sprintf('database.connections.%s.database', $default)),
                'user'     => config(sprintf('database.connections.%s.username', $default)),
                'password' => config(sprintf('database.connections.%s.password', $default)),
                'host'     => config(sprintf('database.connections.%s.host', $default)),
                'port'     => config(sprintf('database.connections.%s.port', $default)),
                'driver'   => $driver,
            ]);
        });
    }
}
