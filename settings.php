<?php

    define('DIR_ROOT', __DIR__.DIRECTORY_SEPARATOR);
    define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR);

    // автозагрузка классов
    set_include_path(
        get_include_path().PATH_SEPARATOR.DIR_ROOT.'db'.PATH_SEPARATOR.DIR_ROOT.'log'
    );
    spl_autoload_extensions('_class.php');
    spl_autoload_register();
    
?>