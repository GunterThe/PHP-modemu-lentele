<?php

class TeritorijaController extends Controller
{
    public function index()
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        $teritorija = $teritorijaModel->getAllTeritorija();
        $this->loadView('teritorija/teritorija', ['teritorija' => $teritorija]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teritorijaModel = $this->loadModel('Teritorija');
            $teritorijaModel->createTeritorija($_POST);
            header('Location: ' . BASE_URL . 'teritorija');
        }
        $this->loadView('teritorija/add_teritorija');
    }

    public function informacijaById($id)
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        $row = $teritorijaModel->getTeritorijaById($id);
        $this->loadView('teritorija/teritorija_single', ['row' => $row]);
    }

    public function edit($id)
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teritorijaModel->updateTeritorija($id, $_POST);
            header('Location: ' . BASE_URL . 'teritorija');
        }
        $row = $teritorijaModel->getTeritorijaById($id);
        $this->loadView('teritorija/update_teritorija', ['row' => $row]);
    }

    public function delete($id)
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        $teritorijaModel->deleteTeritorija($id);
        header('Location: ' . BASE_URL . 'teritorija');
    }
}

?>