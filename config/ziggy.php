<?php

return [
    'skip-route-function' => true,
    'whitelist'           => [
        'push.get-issuestable',
        'push.get-issueliststable',

        'epics.index',
        'epics.destroy',
        'epics.store',
        'epics.update',

        'tasks.index',
        'tasks.destroy',
        'tasks.store',
        'tasks.update',
        'tasks.getTasksByEpic',

        'departments.showAll',

        'taskEstimates.show',
        'taskEstimates.destroy',
        'taskEstimates.store',
        'taskEstimates.update',

        'quotations.create',
        'quotations.store',

        'projects.index',
        'projects.quotations.index'
    ],
];
