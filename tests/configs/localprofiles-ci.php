<?php

use AndrewNicols\Behat\ProfileManager;

return [
    'chrome' => ProfileManager::getBrowserProfile(
        'chrome',
        'http://localhost:4444/wd/hub',
        true,
        [
            'chromeOptions' => [
                'args' => [
                    'use-fake-device-for-media-stream',
                    'use-fake-ui-for-media-stream',
                    'unsafely-treat-insecure-origin-as-secure=http://localhost:8000',
                ],
            ],
        ]
    ),
];
