<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;

class Home extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }

    public function index()
    {
        if ($this->auth->check()) {
            $user       = $this->auth->user();
            $groupModel = new GroupModel();
            $view       = $groupModel->inGroup($user->id, 'admin') ?
            'dashboard/admin/admin_dashboard' : 'dashboard/user/user_dashboard';

            return view($view, ['userName' => $user->username]);
        }

        return redirect()->to('/login');
    }
}
