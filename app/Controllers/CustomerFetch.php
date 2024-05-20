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

    public function list_data()
    {
        $session = session();
        $logged_in_email = $session->get('email');
        $franchiseModel = new Customer_Fetch();

        if ($logged_in_email === "nameeruddin6@gmail.com") {
            $franchises = $franchiseModel->findAll();
        } elseif ($logged_in_email) {
            $franchises = $franchiseModel->where('assignFranchise', $logged_in_email)->findAll();
        } else {
            return $this->response->setJSON(['error' => 'User not logged in']);
        }

        // Return the result as JSON
        return $this->response->setJSON([
            'email' => $logged_in_email,
            'data' => $franchises
        ]);
    }
    public function edit($customerId)
    {
        $customerModel = new Customer_Fetch();
        $customer = $customerModel->find($customerId);
        return view('clients/edit_customer', ['customer' => $customer]);
    }

    public function delete($customerId)
    {
        $customerModel = new Customer_Fetch();
        $customerModel->delete_customer($customerId);
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }
}
