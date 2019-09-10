<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5a89aa36382c4cb079e713358edf4c3f
{
    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\composer\\' => 15,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5a89aa36382c4cb079e713358edf4c3f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5a89aa36382c4cb079e713358edf4c3f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
