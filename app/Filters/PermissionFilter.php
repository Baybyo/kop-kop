<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        if (empty($arguments)) return null;
        $db = \Config\Database::connect();
        $roleId = (int) session()->get('role_id');
        if (!$roleId) {
            $role = session()->get('role');
            $r = $db->table('roles')->where('slug', $role === 'sekretariat' ? 'user' : $role)->get()->getRowArray();
            $roleId = (int) ($r['id'] ?? 0);
        }
        $slugs = $db->table('role_permissions rp')->select('p.slug')->join('permissions p','p.id=rp.permission_id')->where('rp.role_id',$roleId)->get()->getResultArray();
        $have = array_column($slugs, 'slug');
        foreach ($arguments as $need) {
            if (in_array($need, $have, true)) return null;
        }
        if ($request->isAJAX()) return service('response')->setJSON(['error' => 'Forbidden'])->setStatusCode(403);
        return redirect()->to('/dashboard')->with('error','Akses ditolak.');
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
