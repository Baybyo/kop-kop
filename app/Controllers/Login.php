<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) return redirect()->to('/dashboard');
        return view('auth/login', ['mode' => 'user']);
    }

    public function admin()
    {
        if (session()->get('logged_in')) return redirect()->to('/dashboard');
        return view('auth/login_admin', ['mode' => 'admin']);
    }

    public function authenticate()
    {
        helper(['form', 'url']);
        if (!$this->validate(['username' => 'required', 'password' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }
        $username = trim((string)$this->request->getPost('username'));
        $password = (string)$this->request->getPost('password');
        $mode = (string)$this->request->getPost('mode');
        $model = new UserModel();
        $user = $model->where('username', $username)->first();
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau Password salah.');
        }
        $role = $user['role'] ?? 'sekretariat';
        $isAdmin = in_array($role, ['admin','superadmin'], true);
        if ($mode === 'admin' && !$isAdmin) {
            return redirect()->back()->withInput()->with('error', 'Akun ini bukan admin. Gunakan Login Pengguna.');
        }
        if ($mode === 'user' && $isAdmin) {
            return redirect()->back()->withInput()->with('error', 'Akun admin wajib lewat Login Admin.');
        }
        $roleRow = null;
        if (!empty($user['role_id'])) {
            $roleRow = \Config\Database::connect()->table('roles')->where('id', (int)$user['role_id'])->get()->getRowArray();
        }
        if (!$roleRow) {
            $slug = $role === 'sekretariat' ? 'user' : $role;
            $roleRow = \Config\Database::connect()->table('roles')->where('slug', $slug)->get()->getRowArray();
        }
        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'role_id'   => (int)($roleRow['id'] ?? $user['role_id'] ?? 0),
            'role_slug' => $roleRow['slug'] ?? ($role === 'sekretariat' ? 'user' : $role),
            'username'  => $user['username'],
            'name'      => $user['name'],
            'role'      => $role,
            'division_id' => $user['division_id'] ?? null,
        ]);
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
