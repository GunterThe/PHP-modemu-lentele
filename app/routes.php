<?php

$routes = [
    '' => ['controller' => 'InformacijaController', 'method' => 'index'],
    'informacija' => ['controller' => 'InformacijaController', 'method' => 'index'],
    'informacija/add' => ['controller' => 'InformacijaController', 'method' => 'add'],
    'informacija/edit' => ['controller' => 'InformacijaController', 'method' => 'edit'],
    'informacija/delete' => ['controller' => 'InformacijaController', 'method' => 'delete'],
    'informacija/id' => ['controller' => 'InformacijaController', 'method' => 'informacijaById']
];

?>