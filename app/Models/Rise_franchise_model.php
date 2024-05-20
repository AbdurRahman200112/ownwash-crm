<?php

namespace App\Models;

use CodeIgniter\Model;

class Rise_franchise_model extends Model {
    protected $table = 'rise_franchise'; 
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'registration_date',
        'franchise_name',
        'city',
        'mobile_number',
        'email_id',
        'remarks',
        'status'
    ];

    public function save_franchise($postData) {
        return $this->insert($postData);
    }
    
    public function delete_franchise($franchiseId)
    {
        return $this->where('id', $franchiseId)->delete();
    }
}
