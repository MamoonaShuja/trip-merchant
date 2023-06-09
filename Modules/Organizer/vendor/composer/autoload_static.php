<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit09942e73fd715eceb6c1ddf54ab305a9
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Organizer\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Organizer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Modules\\Organizer\\Database\\Seeders\\OrganizerDatabaseSeeder' => __DIR__ . '/../..' . '/Database/Seeders/OrganizerDatabaseSeeder.php',
        'Modules\\Organizer\\Http\\Controllers\\OrganizerController' => __DIR__ . '/../..' . '/Http/Controllers/OrganizerController.php',
        'Modules\\Organizer\\Providers\\OrganizerServiceProvider' => __DIR__ . '/../..' . '/Providers/OrganizerServiceProvider.php',
        'Modules\\Organizer\\Providers\\RouteServiceProvider' => __DIR__ . '/../..' . '/Providers/RouteServiceProvider.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit09942e73fd715eceb6c1ddf54ab305a9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit09942e73fd715eceb6c1ddf54ab305a9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit09942e73fd715eceb6c1ddf54ab305a9::$classMap;

        }, null, ClassLoader::class);
    }
}
