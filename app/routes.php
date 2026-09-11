<?php

$routes = [
    '' => ['controller' => 'InformacijaController', 'method' => 'index'],
    'informacija' => ['controller' => 'InformacijaController', 'method' => 'index'],
    'informacija/add' => ['controller' => 'InformacijaController', 'method' => 'add'],
    'informacija/edit' => ['controller' => 'InformacijaController', 'method' => 'edit'],
    'informacija/delete' => ['controller' => 'InformacijaController', 'method' => 'delete'],
    'informacija/id' => ['controller' => 'InformacijaController', 'method' => 'informacijaById'],
    'teritorija' => ['controller' => 'TeritorijaController', 'method' => 'index'],
    'teritorija/add' => ['controller' => 'TeritorijaController', 'method' => 'add'],
    'teritorija/edit' => ['controller' => 'TeritorijaController', 'method' => 'edit'],
    'teritorija/delete' => ['controller' => 'TeritorijaController', 'method' => 'delete'],
    'teritorija/id' => ['controller' => 'TeritorijaController', 'method' => 'informacijaById'],
];

?>