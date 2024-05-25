<?php

namespace App\Models;

use CodeIgniter\Model;

class DbBpk extends Model
{
    protected $table            = 'db_bpk';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'no_bpk', 'nama_user', 'nik', 'jmlh_uang', 'for_kprln', 'voucher', 'file', 'qr_code','status','rsn_edit','rsn_reject'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
