<?php

class InformacijaController extends Controller
{
    public function index()
    {
        $informacijaModel = $this->loadModel('Informacija');
        $informacija = $informacijaModel->getAllInformacija();
        $this->loadView('informacija/informacija', ['informacija' => $informacija]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $informacijaModel = $this->loadModel('Informacija');
            $informacijaModel->createInformacija($_POST);
            header('Location: ' . BASE_URL . 'informacija');
        }
        $this->loadView('informacija/add_informacija');
    }

    public function informacijaById($id)
    {
        $informacijaModel = $this->loadModel('Informacija');
        $row = $informacijaModel->getInformacijaById($id);
        $this->loadView('informacija/informacija_single', ['row' => $row]);
    }

    public function edit($id)
    {
        $informacijaModel = $this->loadModel('Informacija');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $informacijaModel->updateInformacija($id, $_POST);
            header('Location: ' . BASE_URL . 'informacija');
        }
        $row = $informacijaModel->getInformacijaById($id);
        $this->loadView('informacija/update_informacija', ['row' => $row]);
    }

    public function delete($id)
    {
        $informacijaModel = $this->loadModel('Informacija');
        $informacijaModel->deleteInformacija($id);
        header('Location: ' . BASE_URL . 'informacija');
    }
}

?>