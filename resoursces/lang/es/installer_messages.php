<?php

return [

    /*
     *
     * Traducciones compartidas.
     *
     */
    'title' => 'Instalador de Laravel',
    'next' => 'Siguiente paso',
    'back' => 'Anterior',
    'finish' => 'Instalar',
    'forms' => [
        'errorTitle' => 'Ocurrieron los siguientes errores:',
    ],

    /*
     *
     * Traducciones de la página de inicio.
     *
     */
    'welcome' => [
        'templateTitle' => 'Bienvenido',
        'title'   => 'Instalador de Laravel',
        'message' => 'Asistente de instalación y configuración fácil.',
        'next'    => 'Verificar requisitos',
    ],

    /*
     *
     * Traducciones de la página de requisitos.
     *
     */
    'requirements' => [
        'templateTitle' => 'Paso 1 | Requisitos del servidor',
        'title' => 'Requisitos del servidor',
        'next'    => 'Verificar permisos',
    ],

    /*
     *
     * Traducciones de la página de permisos.
     *
     */
    'permissions' => [
        'templateTitle' => 'Paso 2 | Permisos',
        'title' => 'Permisos',
        'next' => 'Configurar entorno',
    ],

    /*
     *
     * Traducciones de la página de entorno.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Paso 3 | Configuración del entorno',
            'title' => 'Configuración del entorno',
            'desc' => 'Por favor, selecciona cómo deseas configurar el archivo <code>.env</code> de la aplicación.',
            'wizard-button' => 'Configuración con asistente',
            'classic-button' => 'Editor de texto clásico',
        ],
        'wizard' => [
            'templateTitle' => 'Paso 3 | Configuración del entorno | Asistente guiado',
            'title' => 'Asistente guiado para <code>.env</code>',
            'tabs' => [
                'environment' => 'Entorno',
                'database' => 'Base de datos',
                'application' => 'Aplicación',
            ],
            'form' => [
                'name_required' => 'Se requiere un nombre para el entorno.',
                'app_name_label' => 'Nombre de la aplicación',
                'app_name_placeholder' => 'Nombre de la aplicación',
                'app_environment_label' => 'Entorno de la aplicación',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Desarrollo',
                'app_environment_label_qa' => 'QA (Pruebas)',
                'app_environment_label_production' => 'Producción',
                'app_environment_label_other' => 'Otro',
                'app_environment_placeholder_other' => 'Ingresa tu entorno...',
                'app_debug_label' => 'Modo depuración (Debug)',
                'app_debug_label_true' => 'Activado (True)',
                'app_debug_label_false' => 'Desactivado (False)',
                'app_log_level_label' => 'Nivel de registro (Log)',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL de la aplicación',
                'app_url_placeholder' => 'URL de la aplicación',
                'db_connection_failed' => 'No se pudo conectar con la base de datos.',
                'db_connection_label' => 'Conexión de base de datos',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host de la base de datos',
                'db_host_placeholder' => 'Host de la base de datos',
                'db_port_label' => 'Puerto de la base de datos',
                'db_port_placeholder' => 'Puerto de la base de datos',
                'db_name_label' => 'Nombre de la base de datos',
                'db_name_placeholder' => 'Nombre de la base de datos',
                'db_username_label' => 'Usuario de la base de datos',
                'db_username_placeholder' => 'Usuario de la base de datos',
                'db_password_label' => 'Contraseña de la base de datos',
                'db_password_placeholder' => 'Contraseña de la base de datos',

                'app_tabs' => [
                    'more_info' => 'Más información',
                    'broadcasting_title' => 'Transmisión, Caché, Sesión y Cola',
                    'broadcasting_label' => 'Driver de Transmisión (Broadcast)',
                    'broadcasting_placeholder' => 'Driver de Transmisión',
                    'cache_label' => 'Driver de Caché',
                    'cache_placeholder' => 'Driver de Caché',
                    'session_label' => 'Driver de Sesión',
                    'session_placeholder' => 'Driver de Sesión',
                    'queue_label' => 'Driver de Cola (Queue)',
                    'queue_placeholder' => 'Driver de Cola',
                    'redis_label' => 'Driver de Redis',
                    'redis_host' => 'Host de Redis',
                    'redis_password' => 'Contraseña de Redis',
                    'redis_port' => 'Puerto de Redis',

                    'mail_label' => 'Correo',
                    'mail_driver_label' => 'Driver de correo',
                    'mail_driver_placeholder' => 'Driver de correo',
                    'mail_host_label' => 'Host de correo',
                    'mail_host_placeholder' => 'Host de correo',
                    'mail_port_label' => 'Puerto de correo',
                    'mail_port_placeholder' => 'Puerto de correo',
                    'mail_username_label' => 'Usuario de correo',
                    'mail_username_placeholder' => 'Usuario de correo',
                    'mail_password_label' => 'Contraseña de correo',
                    'mail_password_placeholder' => 'Contraseña de correo',
                    'mail_encryption_label' => 'Cifrado de correo',
                    'mail_encryption_placeholder' => 'Cifrado de correo',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App Id',
                    'pusher_app_id_palceholder' => 'Pusher App Id',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => 'Pusher App Key',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => 'Pusher App Secret',
                ],
                'buttons' => [
                    'setup_database' => 'Configurar base de datos',
                    'setup_application' => 'Configurar aplicación',
                    'install' => 'Instalar',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Paso 3 | Configuración del entorno | Editor clásico',
            'title' => 'Editor de entorno clásico',
            'save' => 'Guardar .env',
            'back' => 'Usar asistente de formulario',
            'install' => 'Guardar e instalar',
        ],
        'success' => 'Los ajustes de tu archivo .env han sido guardados.',
        'errors' => 'No se pudo guardar el archivo .env, por favor créalo manualmente.',
    ],

    'install' => 'Instalar',

    /*
     *
     * Traducciones del registro (Log) de instalación.
     *
     */
    'installed' => [
        'success_log_message' => 'Instalador de Laravel INSTALADO con éxito el ',
    ],

    /*
     *
     * Traducciones de la página final.
     *
     */
    'final' => [
        'title' => 'Instalación terminada',
        'templateTitle' => 'Instalación terminada',
        'finished' => 'La aplicación ha sido instalada con éxito.',
        'migration' => 'Salida de la consola de Migraciones y Semillas (Seed):',
        'console' => 'Salida de la consola de la aplicación:',
        'log' => 'Entrada del registro de instalación:',
        'env' => 'Archivo .env final:',
        'exit' => 'Haz clic aquí para salir',
    ],

    /*
     *
     * Traducciones específicas del actualizador
     *
     */
    'updater' => [
        /*
         *
         * Traducciones compartidas.
         *
         */
        'title' => 'Actualizador de Laravel',

        /*
         *
         * Traducciones de la página de bienvenida para la función de actualización.
         *
         */
        'welcome' => [
            'title'   => 'Bienvenido al actualizador',
            'message' => 'Bienvenido al asistente de actualización.',
        ],

        /*
         *
         * Traducciones de la página de resumen.
         *
         */
        'overview' => [
            'title'   => 'Resumen',
            'message' => 'Hay 1 actualización disponible.|Hay :number actualizaciones disponibles.',
            'install_updates' => 'Instalar actualizaciones',
        ],

        /*
         *
         * Traducciones de la página final.
         *
         */
        'final' => [
            'title' => 'Terminado',
            'finished' => 'La base de datos de la aplicación se ha actualizado con éxito.',
            'exit' => 'Haz clic aquí para salir',
        ],

        'log' => [
            'success_message' => 'Instalador de Laravel ACTUALIZADO con éxito el ',
        ],
    ],
];