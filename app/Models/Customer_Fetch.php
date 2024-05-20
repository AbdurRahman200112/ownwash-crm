<?php
namespace App\Models;

use CodeIgniter\Model;

class Customer_Fetch extends Model {
    protected $table = 'rise_customer';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'registrationDate',
        'customerName',
        'address',
        'mobile',
        'carSegments',
        'hours',
        'minutes',
        'meridiem',
        'amount',
        'assignFranchise',
        'status',
        'anyRemarks'
    ];
    public function isAdmin($email)
    {
        $user = $this->where('email', $email)->first();

        // Check if the user exists and is an admin
        return $user && $user['is_admin'] == 1;
    }
    public function delete_customer($customerId)
    {
        // Find the customer record by ID and delete it
        return $this->where('id', $customerId)->delete();
    }
}
