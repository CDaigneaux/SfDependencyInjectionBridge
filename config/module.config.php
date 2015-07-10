<?php
return [
    'service_manager' => [
        'abstract_factories' => [
            'Cdx\\SfDependencyInjectionBridge\\AbstractFactory',
        ],
        'factories' => [
            'Cdx\\SfDependencyInjectionBridge\\ContainerBuilder' => 'Cdx\\SfDependencyInjectionBridge\\ContainerBuilderFactory',
            'Cdx\\SfDependencyInjectionBridge\\ModuleOptions'    => 'Cdx\\SfDependencyInjectionBridge\\ModuleOptionsFactory',
        ]
    ],
];
