<?php

class InformacijaController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $search = $_GET['search'];
            $informacijaModel = $this->loadModel('Informacija');
            $informacija = $informacijaModel->searchInformacija($search);
        } else {
            $informacijaModel = $this->loadModel('Informacija');
            $informacija = $informacijaModel->getAllInformacija();
        }
        $this->loadView('informacija/informacija', ['informacija' => $informacija]);
    }

    public function add()
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        $teritorija = $teritorijaModel->getAllTeritorija();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $informacijaModel = $this->loadModel('Informacija');
            $informacijaModel->createInformacija($_POST);
            header('Location: ' . BASE_URL . 'informacija');
        }
        $this->loadView('informacija/add_informacija', ['teritorija' => $teritorija]);
    }

    public function informacijaById($id)
    {
        $informacijaModel = $this->loadModel('Informacija');
        $row = $informacijaModel->getInformacijaById($id);
        $this->loadView('informacija/informacija_single', ['row' => $row]);
    }

    public function edit($id)
    {
        $teritorijaModel = $this->loadModel('Teritorija');
        $teritorija = $teritorijaModel->getAllTeritorija();
        $informacijaModel = $this->loadModel('Informacija');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $informacijaModel->updateInformacija($id, $_POST);
            header('Location: ' . BASE_URL . 'informacija');
        }
        $row = $informacijaModel->getInformacijaById($id);
        $this->loadView('informacija/update_informacija', ['row' => $row, 'teritorija' => $teritorija]);
    }

    public function delete($id)
    {
        $informacijaModel = $this->loadModel('Informacija');
        $informacijaModel->deleteInformacija($id);
        header('Location: ' . BASE_URL . 'informacija');
    }
}

?>