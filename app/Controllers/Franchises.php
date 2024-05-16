<?php

namespace App\Controllers;

use App\Models\FranchiseModel;


use CodeIgniter\Controller;

class Franchises extends Controller
{
    public function index()
    {
        return view('/projects/index');
    }
    public function list()
    {
        $franchiseModel = new FranchiseModel();
        $franchises = $franchiseModel->findAll();
        return $this->response->setJSON($franchises);
    }
}
