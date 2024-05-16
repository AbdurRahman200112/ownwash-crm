<?php

namespace App\Controllers;

use App\Models\Customer_Fetch;
use CodeIgniter\Controller;

class CustomerFetch extends Controller
{
    public function index()
    {
        return view('/clients/index');
    }
    public function list_data()
    {
        $franchiseModel = new Customer_Fetch();
        $franchises = $franchiseModel->findAll();
        return $this->response->setJSON($franchises);
    }
}