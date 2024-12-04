<?php

declare(strict_types=1);

return [
    'components' => [
        'cache' => [
            'columnSpan' => 'full',
            'rows' => 2,
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'exceptions' => [
            'columnSpan' => 'full',
            'rows' => 2,
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'queues' => [
            'columnSpan' => 'full',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'servers' => [
            'columnSpan' => 'full',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'slow-out-going' => [
            'columnSpan' => '2',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'slow-queries' => [
            'columnSpan' => 'full',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'slow-requests' => [
            'columnSpan' => 'full',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'usage' => [
            'columnSpan' => 'full',
            'rows' => 2,
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],

        'slow-jobs' => [
            'columnSpan' => 'full',
            'cols' => 'full',
            'ignoreAfter' => '1 day',
            'isDiscovered' => true,
            'isLazy' => true,
            'sort' => null,
            'canView' => true,
            'columnStart' => [],
        ],
    ],
];
