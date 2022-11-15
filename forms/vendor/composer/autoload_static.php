<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0c9c48e212b0842b2b2d8454116137bb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PragmaRX\\Google2FA\\' => 19,
            'ParagonIE\\ConstantTime\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PragmaRX\\Google2FA\\' => 
        array (
            0 => __DIR__ . '/..' . '/pragmarx/google2fa/src',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0c9c48e212b0842b2b2d8454116137bb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0c9c48e212b0842b2b2d8454116137bb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0c9c48e212b0842b2b2d8454116137bb::$classMap;

        }, null, ClassLoader::class);
    }
}
