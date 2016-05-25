<?php

$loader = new \Phalcon\Loader();

/**
 * Registrando os diretórios que foram definidos no arquivo de configuração.
 */
$loader->registerDirs(
    array(
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->pluginsDir,
        APP_PATH . $config->application->libraryDir,
        APP_PATH . $config->application->modelsDir,
        APP_PATH . $config->application->formsDir,
    )
)->register();

