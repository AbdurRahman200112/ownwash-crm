<?php

namespace App\Models;

use CodeIgniter\Model;

class FranchiseModel extends Model
{
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
}
