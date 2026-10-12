<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'name', 'role', 'role_id', 'division_id', 'nip', 'jabatan', 'pangkat_golongan', 'status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function attemptLogin(string $username, string $password): bool
    {
        $user = $this->where('username', $username)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return true;
    }
}