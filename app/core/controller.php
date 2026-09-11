<?php

class Controller
{
    protected function loadModel($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    protected function loadView($view, $data = [])
    {
        extract($data);
        require_once '../app/views/layout.php';
    }
}

?>