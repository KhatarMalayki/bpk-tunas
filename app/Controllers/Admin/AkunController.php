<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class AkunController extends BaseController
{
    protected $userModel;
    protected $db, $builder;
    protected $groupModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }
    public function index()
    {
        $data_user = $this->builder->get()->getResultObject();
        $data_group = $this->db->table('auth_groups')->get()->getResultObject(); // Ambil semua grup sekali saja
        // Ambil data pengguna yang termasuk dalam grup dengan ID 2
        // $groupId = 2; // ID grup yang ingin Anda cari pengguna-pengguna yang terkait dengannya
        // $usersInGroup = $this->groupModel->getUsersForGroup($groupId);
        
        // foreach ($usersInGroup as $user) {
        //     // Mengakses email dari setiap pengguna
        //     $emails[] = $user['email'];
           
        // }
        // dd($emails);
        foreach ($data_user as &$user) {
            $user->groups = $this->groupModel->getGroupsForUser($user->id);// Ambil grup untuk pengguna tertentu
            // dd($user); 
        }

        $data = [
            'title' => 'Data Akun',
            'data_user' => $data_user,
            'data_group' => $data_group,
        ];

        return view('admin/akun/index', $data);
    }



    public function detail($id)
    {
        $data = [
            'title' => 'Detail Akun',
            'data_user' => $this->userModel->find($id),
            'data_group' => $this->groupModel->getGroupsForUser($id),
        ];

        // dd($data);

        return view('admin/akun/detail', $data);
    }


    public function update($id)
    {
        $username = (string) $this->request->getPost('username');
        $email = (string) $this->request->getPost('email');
        $dataGroup = $this->groupModel->getGroupsForUser($id);
        $groupID = (string) $this->request->getPost('group'); // Ambil Nama grup dari inputan form
        $password = (string) $this->request->getPost('password');
        // dd($password);

        // Memeriksa apakah input password tidak kosong
        if (!empty($password)) {
            $user = new \Myth\Auth\Entities\User();
            $user->setPassword($password);
            $password_hash = $user->password_hash;
        }

        $data = [
            'username' => strip_tags($username),
            'email' => strip_tags($email),
        ];

        // Jika password tidak kosong, tambahkan ke data yang akan diupdate
        if (!empty($password_hash)) {
            $data['password_hash'] = $password_hash;
        }

        // Cek jika $dataGroup sudah ada
        if (empty($dataGroup)) {
            // Jika belum ada, tambahkan user ke grup
            $this->groupModel->addUserToGroup($id, $groupID);
            $this->builder->where('id', $id)->update($data);
            return redirect()->back()->with('success', 'user ini berhasil diubah/ditambahkan ke grup.');
        } else {
            // Jika sudah ada, ubah user ke grup
            $this->groupModel->removeUserFromGroup($id, $dataGroup[0]['group_id']);
            $this->groupModel->addUserToGroup($id, $groupID);
            $this->builder->where('id', $id)->update($data);
            return redirect()->back()->with('success', 'user group ini berhasil diubah.');
        }
    }



    public function destroy($id)
    {
        $this->groupModel->removeUserFromAllGroups($id);
        $this->builder->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
}
