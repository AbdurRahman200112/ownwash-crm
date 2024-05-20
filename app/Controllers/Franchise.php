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
            'email_id' => 'required|valid_email',
            'remarks' => 'required',
            'status' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $franchiseModel = new Rise_franchise_model();
        if ($franchiseModel->save_franchise($this->request->getPost())) {
            return redirect()->to('/projects/index')->with('success', 'Franchise saved successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Unable to save franchise data.']);
        }
    }

    public function edit($franchiseId)
    {
        $franchiseModel = new Rise_franchise_model();
        $franchise = $franchiseModel->find($franchiseId);

        if (!$franchise) {
            return redirect()->to('/franchise')->with('errors', ['Franchise not found']);
        }

        return view('projects/edit_franchise', ['franchise' => $franchise]);
    }

    public function delete($franchiseId)
    {
        $franchiseModel = new Rise_franchise_model();
        if ($franchiseModel->delete_franchise($franchiseId)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Unable to delete franchise']);
        }
    }

    public function update($id)
    {
        $franchiseModel = new Rise_franchise_model();
        $franchise = $franchiseModel->find($id);

        if (!$franchise) {
            return redirect()->to(site_url('franchise'))->with('errors', ['Franchise not found']);
        }

        helper(['form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'registration_date' => 'required',
            'franchise_name' => 'required',
            'city' => 'required',
            'mobile_number' => 'required',
            'email_id' => 'required|valid_email',
            'remarks' => 'required',
            'status' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'registration_date' => $this->request->getPost('registration_date'),
            'franchise_name' => $this->request->getPost('franchise_name'),
            'city' => $this->request->getPost('city'),
            'mobile_number' => $this->request->getPost('mobile_number'),
            'email_id' => $this->request->getPost('email_id'),
            'remarks' => $this->request->getPost('remarks'),
            'status' => $this->request->getPost('status')
        ];

        if ($franchiseModel->update($id, $data)) {
            return redirect()->to(site_url('projects/edit_franchise'))->with('success', 'Franchise updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Unable to update franchise data.']);
        }
    }
}
