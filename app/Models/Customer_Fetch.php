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
    
}
