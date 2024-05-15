<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $db, $builder;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }
    public function index()
    {
        if (!in_groups(['admin'])) {
            // Arahkan pengguna kembali ke halaman beranda
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Dashboard',
            'totalApv_Rjt' => $this->dbBpk->whereIn('status', ['Approved', 'Rejected'])->countAllResults(),
            'totalOutstanding' => $this->dbBpk->where('status', 'In-Process')->countAllResults(),
            'totalUser' => $this->builder->countAllResults(),
            'totalForm' => $this->dbBpk->countAllResults(),
            'data_Bpk' => $this->dbBpk->whereIn('status', ['Approved', 'Rejected'])->Limit(3)->orderBy('id', 'DESC')->find(),
        ];
        return view('admin/dashboard/index', $data);
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('admin/dashboard/dashboard');
    }
}
