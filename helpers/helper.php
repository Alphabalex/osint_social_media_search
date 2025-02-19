<?php
if (!function_exists('config')) {


    function getConfig($key = null, $default = null)
    {
        static $loadedConfigs = [];

        if (is_null($key)) {
            return null;
        }

        $keys = explode('.', $key);

        $fileName = array_shift($keys);


        if (!isset($loadedConfigs[$fileName])) {
            $filePath = __DIR__ . '/../config/' . $fileName . '.php';

            if (file_exists($filePath)) {
                $loadedConfigs[$fileName] = require $filePath;
            } else {
                return $default;
            }
        }

        $config = $loadedConfigs[$fileName];

        foreach ($keys as $part) {
            if (is_array($config) && array_key_exists($part, $config)) {
                $config = $config[$part];
            } else {
                return $default;
            }
        }

        return $config;
    }

    
}
