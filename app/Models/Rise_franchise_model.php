<?php

namespace App\Models;

use CodeIgniter\Model;

class Rise_franchise_model extends Model {
    protected $table = 'rise_franchise'; // specify table name

    protected $allowedFields = [
        'registration_date',
        'franchise_name',
        'city',
        'mobile_number',
        'email_id',
        'remarks',
        'status'
    ];

    // Change method name to save_franchise
    public function save_franchise($postData) {
        $this->insert($postData);
    }

    // You can add other model methods here if needed
}
