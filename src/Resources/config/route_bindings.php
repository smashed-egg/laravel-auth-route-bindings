<?php

return [
    'models' => [

        /*
         * Route binding name
         */
        'userPost' => [
            /*
             * Class of model
             */
            'class' => \App\Models\Post::class,

            /*
             * Table field name for class
             */
            'field' => 'id',

            /*
             * Foreign key name for User
             */
            'fk_user_id' => 'user_id',
        ]
    ]
];
