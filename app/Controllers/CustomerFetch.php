<?php

namespace App\Controllers;

use App\Models\Customer_Fetch;
use CodeIgniter\Controller;
use Stripe\Customer;

class CustomerFetch extends Controller
{
    public function index()
    {
        return view('/customers/index');
    }

    // public function list_data()
    // {
    //     $session = session();
    //     $logged_in_email = $session->get('email');
    //     $franchiseModel = new Customer_Fetch();

    //     if ($logged_in_email === "nameeruddin6@gmail.com") {
    //         $franchises = $franchiseModel->findAll();
    //     } elseif ($logged_in_email) {
    //         $franchises = $franchiseModel->where('assignFranchise', $logged_in_email)->findAll();
    //     } else {
    //         return $this->response->setJSON(['error' => 'User not logged in']);
    //     }

    //     // Return the result as JSON
    //     return $this->response->setJSON([
    //         'email' => $logged_in_email,
    //         'data' => $franchises
    //     ]);
    // }
    public function list_data()
    {
        $session = session();
        $logged_in_email = $session->get('email');
        $franchiseModel = new Customer_Fetch();

        // Get the start and end dates from the request parameters
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        if ($logged_in_email === "nameeruddin6@gmail.com") {
            // Fetch all data if admin is logged in
            $franchises = $franchiseModel->findAll();
        } elseif ($logged_in_email) {
            // Filter data by assignFranchise if a regular user is logged in
            $franchises = $franchiseModel
                ->where('assignFranchise', $logged_in_email)
                ->where('registrationDate >=', $start_date)
                ->where('registrationDate <=', $end_date)
                ->findAll();
        } else {
            return $this->response->setJSON(['error' => 'User not logged in']);
        }

        // Return the result as JSON
        return $this->response->setJSON([
            'email' => $logged_in_email,
            'data' => $franchises
        ]);
    }

    public function update_data()
    {
        $request = \Config\Services::request();
        $franchiseModel = new Customer_Fetch();

        $id = $request->getPost('id');
        $data = [
            'registrationDate' => $request->getPost('registrationDate'),
            'customerName' => $request->getPost('customerName'),
            'address' => $request->getPost('address'),
            'mobile' => $request->getPost('mobile'),
            'carSegments' => $request->getPost('carSegments'),
            'hours' => $request->getPost('hours'),
            'minutes' => $request->getPost('minutes'),
            'meridiem' => $request->getPost('meridiem'),
            'amount' => $request->getPost('amount'),
            'assignFranchise' => $request->getPost('assignFranchise'),
            'status' => $request->getPost('status'),
            'anyRemarks' => $request->getPost('anyRemarks'),
        ];

        if ($franchiseModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function delete($customerId)
    {
        $customerModel = new Customer_Fetch();
        $customerModel->delete_customer($customerId);
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }
}
