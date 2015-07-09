<?php
return [
    'service_manager' => [
        'abstract_factories' => [
            'SfDependencyInjectionBridge\\AbstractFactory',
        ],
        'factories' => [
            'SfDependencyInjectionBridge\\ContainerBuilder' => 'SfDependencyInjectionBridge\\ContainerBuilderFactory',
        ]
    ],
];
