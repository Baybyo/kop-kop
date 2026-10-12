<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuratModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        helper('kopsurat');
        $role = session()->get('role');
        $isAdmin = in_array($role, ['admin', 'superadmin'], true);

        $suratModel = new SuratModel();
        $userModel = new UserModel();
        $userId = (int)session()->get('user_id');

        $stats = [];
        if ($isAdmin) {
            $stats = [
                'totalSurat' => $suratModel->countAllResults(),
                'totalUser'  => $userModel->countAllResults(),
                'pendingVerif' => (clone $suratModel)->where('status', 'draft')->countAllResults(),
                'verifiedCount' => (clone $suratModel)->where('status', 'verified')->countAllResults(),
                'rejectedCount' => (clone $suratModel)->where('status', 'rejected')->countAllResults(),
            ];
        } else {
            $stats = [
                'totalSaya' => (clone $suratModel)->where('user_id', $userId)->countAllResults(),
                'draftCount' => (clone $suratModel)->where('user_id', $userId)->where('status', 'draft')->countAllResults(),
                'disetujuiCount' => (clone $suratModel)->where('user_id', $userId)->where('status', 'verified')->countAllResults(),
                'pendingCount' => (clone $suratModel)->where('user_id', $userId)->where('status', 'draft')->countAllResults(),
            ];
        }

        $data = [
            'title'     => 'Dashboard',
            'active'    => 'beranda',
            'username'  => session()->get('username'),
            'name'      => session()->get('name'),
            'role'      => $role,
            'isAdmin'   => $isAdmin,
            'stats'     => $stats,
            'suratDari' => suratDariByRole($role),
            'notifCount' => 0, 'notifItems' => [],
        ];
        if (session()->get('logged_in')) {
            $notif = notificationData($role, (int)session()->get('user_id'));
            $data['notifCount'] = $notif['count'];
            $data['notifItems'] = $notif['items'];
        }

        return view('dashboard/index', $data);
    }
}
