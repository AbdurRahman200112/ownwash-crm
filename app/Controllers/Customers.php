<?php

namespace App\Controllers;

use App\Models\User_model;
use App\Models\Customer_model;
use CodeIgniter\Controller;

class Customers extends Controller
{
    public function assign_franchise()
    {
        $userModel = new User_model();
        $data['staffUserFirstNames'] = $userModel->getStaffUserFirstNames();

        // Debugging output
        echo '<pre>';
        print_r($data['staffUserFirstNames']);
        echo '</pre>';

        if (empty($data['staffUserFirstNames'])) {
            log_message('error', 'No staff users found.');
            echo "No staff users available.";
        } else {
            log_message('info', 'Staff user first names passed to view: ' . print_r($data['staffUserFirstNames'], true));
        }

        return view('clients/modal_form', $data);
    }
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
