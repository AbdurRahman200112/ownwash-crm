<?php
namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'rise_users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getStaffUserFirstNames()
    {
        try {
            return $this->select('first_name')->where('user_type', 'staff')->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error fetching staff user first names: ' . $e->getMessage());
            return [];
        }
    }
}
