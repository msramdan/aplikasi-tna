<?php

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if you want to name the related pivots other than defaults
         */
        'role_pivot_key' => null, //default 'role_id',
        'permission_pivot_key' => null, //default 'permission_id',

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use the teams feature and your related model's
         * foreign key is other than `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false, if you want to implement custom logic for checking permissions.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true the package implements teams using the 'team_foreign_key'. If you want
     * the migrations to register the 'team_foreign_key', you must set this to true
     * before doing the migration. If you already did the migration then you must make a new
     * migration to also add 'team_foreign_key' to 'roles', 'model_has_roles', and
     * 'model_has_permissions'(view the latest version of package's migration file)
     */

    'teams' => false,

    /*
     * When set to true, the required permission names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     */

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],

    'permissions' => [
        [
            'group' => 'users',
            'access' => [
                'user view',
                // 'user create',
                'user edit',
                'user delete',
            ]
        ],
        [
            'group' => 'roles & permissions',
            'access' => [
                'role & permission view',
                // 'role & permission create',
                'role & permission edit',
                'role & permission delete',
            ]
        ],
        ['group' => 'tagging pembelajaran kompetensi', 'access' => ['tagging pembelajaran kompetensi view', 'tagging pembelajaran kompetensi edit', 'tagging pembelajaran kompetensi delete','tagging pembelajaran kompetensi import','tagging pembelajaran kompetensi export']],
        ['group' => 'tagging kompetensi ik', 'access' => ['tagging kompetensi ik view', 'tagging kompetensi ik edit', 'tagging kompetensi ik delete', 'tagging kompetensi ik import', 'tagging kompetensi ik export']],
        ['group' => 'rumpun pembelajaran', 'access' => ['rumpun pembelajaran view', 'rumpun pembelajaran create', 'rumpun pembelajaran edit', 'rumpun pembelajaran delete']],
        ['group' => 'topik', 'access' => ['topik view', 'topik create', 'topik edit', 'topik delete','topik import','topik export']],
        ['group' => 'jadwal kap tahunan', 'access' => ['jadwal kap tahunan view', 'jadwal kap tahunan create', 'jadwal kap tahunan edit', 'jadwal kap tahunan delete']],
        ['group' => 'pengajuan kap', 'access' => ['pengajuan kap view', 'pengajuan kap tahunan bpkp', 'pengajuan kap tahunan non bpkp', 'pengajuan kap insidentil bpkp', 'pengajuan kap insidentil non bpkp', 'pengajuan kap edit', 'pengajuan kap delete', 'pengajuan kap skiped']],
        ['group' => 'config step review', 'access' => ['config step review view', 'config step review edit']],
        ['group' => 'nomenklatur pembelajaran', 'access' => ['nomenklatur pembelajaran view', 'nomenklatur pembelajaran edit']],
        ['group' => 'setting apps', 'access' => ['setting app view', 'setting app edit']],
        ['group' => 'pengumumen', 'access' => ['pengumuman view','pengumuman edit']],
        ['group' => 'kompetensi', 'access' => ['kompetensi view', 'kompetensi create','kompetensi import','kompetensi export']],
        ['group' => 'activity log', 'access' => ['activity log view']],
        ['group' => 'lokasi', 'access' => ['lokasi view']],
        ['group' => 'backup database', 'access' => ['backup database view']],
        ['group' => 'sync pusdiklatwas ', 'access' => ['sinkronisasi view']],
        ['group' => 'kalender pembelajaran', 'access' => ['kalender pembelajaran view']],

    ],
];
