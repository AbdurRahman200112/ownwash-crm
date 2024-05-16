<?php
namespace App\Models;

use CodeIgniter\Model;

class Customer_model extends Model {

    public function save_customer($postData) {
        $data = array(
            'registrationDate' => $postData['registrationDate'] ?? null,
            'customerName' => $postData['customerName'] ?? null,
            'address' => $postData['address'] ?? null,
            'mobile' => $postData['mobile'] ?? null,
            'carSegments' => $postData['carSegments'] ?? null,
            'hours' => $postData['hours'] ?? null,
            'minutes' => $postData['minutes'] ?? null,
            'meridiem' => $postData['meridiem'] ?? null,
            'amount' => $postData['amount'] ?? null,
            'assignFranchise' => $postData['assignFranchise'] ?? null,
            'status' => $postData['status'] ?? null,
            'anyRemarks' => $postData['anyRemarks'] ?? null
        );
    
        $this->db->table('rise_customer')->insert($data);
    }
}