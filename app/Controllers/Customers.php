<?php

namespace App\Controllers;

use App\Models\Customer_model;
use CodeIgniter\Controller;

class Customers extends Controller
{
    public function save()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'registrationDate' => 'required'
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $customerModel = new Customer_model();
            $customerModel->save_customer($this->request->getPost());
            return redirect()->to('/clients/index')->with('success', 'Customer saved successfully');
        }
    }
}
