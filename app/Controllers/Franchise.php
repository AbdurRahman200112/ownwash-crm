<?php

namespace App\Controllers;

use App\Models\Rise_franchise_model;
use CodeIgniter\Controller;

class Franchise extends Controller
{
    public function save()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'registration_date' => 'required',
            'franchise_name' => 'required',
            'city' => 'required',
            'mobile_number' => 'required',
            'email_id' => 'required',
            'remarks' => 'required',
            'status' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $franchiseModel = new Rise_franchise_model();
            $franchiseModel->save_franchise($this->request->getPost()); // Use save_franchise method
            return redirect()->to('/projects/index')->with('success', 'Franchise saved successfully');
        }
    }
}
