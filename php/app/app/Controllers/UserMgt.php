<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; 
use CodeIgniter\Shield\Entities\User;

use App\Models\MenuModel;


class UserMgt extends BaseController
{
    //
    // Init Session (Admin-Messages)
    //

    protected $session;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    
    // Overview

    public function user_mgt()
    {
        helper('form');

        $model_menu = model(MenuModel::class); 
        $model_stations = model(StationsModel::class);

        $data['cat'] = 'user';
        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Benutzerverwaltung');
        $data['user'] = auth()->user()->username;
        $data['email'] = auth()->user()->email;
        $data['user_created_at'] = auth()->user()->created_at;
        $data['groups'] = auth()->user()->getGroups();
        $data['title'] = 'Admin - Benutzerverwaltung';
        $data['menu'] = $model_menu->getMenu();
        $data['is_admin'] = auth()->user()->inGroup('superadmin');
        $data['is_superadmin'] = auth()->user()->inGroup('superadmin');
        $data['redirectedErrorsMail'] = session()->getFlashdata("redirectedErrorsMail") ?: "";
        $data['redirectedErrorsNew'] = session()->getFlashdata("redirectedErrorsNew") ?: "";
        $data['redirectedErrorsPw'] = session()->getFlashdata("redirectedErrorsPw") ?: "";
        $data['validation'] = \Config\Services::validation();

        $users = auth()->getProvider();
        $all_users = [];

            foreach ($users->findAll() as $user) {
                $my_groups = $user->getGroups();
                asort($my_groups);
                $groups =  implode(", ", $my_groups);

                $lastloginstr = "";
                if (!is_null($user->lastLogin())) {
                    $lastloginstr = $user->lastLogin()->date->format('Y-m-d H:i:s');
                }

                array_push($all_users, [$user->id,$user->username,$user->email,$lastloginstr,$user->created_at->format('Y-m-d H:i:s')]);
            }

        $data['all_users'] = $all_users;

        return view('templates/header', $data)
        . view('templates/menu')
        . view('templates/menu_adminside')
        . view('usermgt/main')
        . view('templates/footer');
    }

    public function user_mgt_password_post()
    {
        helper('form');

        $data = $this->request->getPost(['old_password', 'new_password_1', 'new_password_2']);

        if (! $this->validateData($data, [
            'old_password' => 'required',
            'new_password_1' => 'required|min_length[5]|max_length[25]',
            'new_password_2' => 'required|min_length[5]|max_length[25]|matches[new_password_1]',
        ])) {
            $validation = \Config\Services::validation();

            return redirect()
                ->to(base_url('admin/usermgt') . "#pw")
                ->with("redirectedErrorsPw", $validation->listErrors());
        }

        $post = $this->validator->getValidated();

        $p_old = $post['old_password'];
        $p1 = $post['new_password_1'];
        $p2 = $post['new_password_2'];

        $result = auth()->check([
            'username' => auth()->user()->username,
            'password' => $p_old,
        ]);
    
        // old password not correct
        if(!$result->isOK()) {
            $error = lang('Auth.errorOldPassword');    
            return redirect()->to(base_url('admin/usermgt'))->with('adminmessage_pw', "Altes Passwort falsch.");
        }

        $users = auth()->getProvider();
        $user = auth()->user();
        $user->fill([
            'password' => $p1
        ]);
        $users->save($user);

        return redirect()->to(base_url('admin/usermgt') . "#pw")->with('adminmessage_pw', "Passwort geändert.");
    }

    public function user_mgt_email_post()
    {
        helper('form');

        $data = $this->request->getPost(['email']);

        $users = auth()->getProvider();
        $user = auth()->user();

        if ($user->email == $data["email"]) {
            return redirect()->to(base_url('admin/usermgt') . "#base")->with('adminmessage_email', "Keine Änderung.");
        }

        if (! $this->validateData($data, [
            'email' => 'required|valid_email|is_unique[auth_identities.secret]',
        ])) {
            $validation = \Config\Services::validation();

            return redirect()
                ->to(base_url('admin/usermgt') . "#base")
                ->with("redirectedErrorsMail", $validation->listErrors());
        }

        $post = $this->validator->getValidated();

        $email = $post['email'];


        $user->fill([
            'email' => $email
        ]);
        $users->save($user);

        return redirect()->to(base_url('admin/usermgt') . "#base")->with('adminmessage_email', "E-Mail erfolgreich geändert.");
    }

    public function user_mgt_emailid_post(?int $id = null)
    {
        helper('form');

        $data = $this->request->getPost(['email']);

        if (! $this->validateData($data, [
            'email' => 'required|valid_email|is_unique[auth_identities.secret]',
        ])) {
            return $this->user_mgt();
        }

        $post = $this->validator->getValidated();

        $email = $post['email'];

        $users = auth()->getProvider();
        $user = $users->findById($id);
        $user->fill([
            'email' => $email
        ]);
        $users->save($user);

        return redirect()->to(base_url('admin/usermgt/update/' . $id) . "#base")->with('adminmessage_email', "E-Mail erfolgreich geändert.");
    }

    public function user_mgt_passwordid_post(?int $id = null)
    {
        helper('form');

        $data = $this->request->getPost(['id', 'new_password_1', 'new_password_2']);

        if (! $this->validateData($data, [
            'new_password_1' => 'required|min_length[5]|max_length[25]',
            'new_password_2' => 'required|min_length[5]|max_length[25]|matches[new_password_1]',
        ])) {
            $validation = \Config\Services::validation();

            return redirect()
                ->to(base_url('admin/usermgt/update/') . $id . "#pw")
                ->with("redirectedErrorsPw", $validation->listErrors());
        }

        $post = $this->validator->getValidated();

        $p1 = $post['new_password_1'];
        $p2 = $post['new_password_2'];


        $users = auth()->getProvider();
        $user = $users->findById($id);

        $user->fill([
            'password' => $p1
        ]);
        $users->save($user);

        return redirect()->to(base_url('admin/usermgt/update/' . $id . '#pw'))->with('adminmessage_pw', "Passwort geändert.");
    }

    public function user_mgt_new_post()
    {
        helper('form');

        $data = $this->request->getPost(['username', 'email', 'pw_1', 'pw_2']);

        if (! $this->validateData($data, [
            'username' => 'required|min_length[4]|max_length[25]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[auth_identities.secret]',
            'pw_1' => 'required|min_length[5]|max_length[25]',
            'pw_2' => 'required|min_length[5]|max_length[25]|matches[pw_1]',
        ])) {
            $validation = \Config\Services::validation();

            return redirect()
                ->to(base_url('admin/usermgt') . "#new")
                ->with("redirectedErrorsNew", $validation->listErrors());
        } 

        $post = $this->validator->getValidated();

        $username = $post['username'];
        $email = $post['email'];
        $p1 = $post['pw_1'];

        $users = auth()->getProvider();

        $user = new User([
            'username' => $username,
            'email' => $email,
            'password' => $p1,
        ]);
        $users->save($user);

        return redirect()->to(base_url('admin/usermgt') . "#new")->with('adminmessage_newuser', "User angelegt.");
    }

    public function user_mgt_update(?int $id = null)
    {
        helper('form');

        $model_menu = model(MenuModel::class); 

        $users = auth()->getProvider();
        $user = $users->findById($id);

        $data['menu_admin_side'] = $model_menu->getMenuAdminSide('Benutzerverwaltung');
        $data['cat'] = 'user';
        $data['id'] = $id;
        $data['user'] = $user->username;
        $data['email'] = $user->email;
        $data['user_created_at'] = $user->created_at;
        $data['groups'] = $user->getGroups();
        $data['title'] = 'Benutzerverwaltung';
        $data['menu'] = $model_menu->getMenu();
        $data['validation'] = \Config\Services::validation();
        $data['redirectedErrorsPw'] = session()->getFlashdata("redirectedErrorsPw") ?: "";
        $data['redirectedErrorsBase'] = session()->getFlashdata("redirectedErrorsBase") ?: "";
        $data['redirectedErrorsSontaran'] = session()->getFlashdata("redirectedErrorsSontaran") ?: "";

        return view('templates/header', $data)
        . view('templates/menu')
        . view('templates/menu_adminside')

        . view('usermgt/update')
        . view('templates/footer');
    }

    public function user_mgt_update_post()
    {
        helper('form');

        $data = $this->request->getPost(['id', 'email']);
        $users = auth()->getProvider();
        $user = $users->findById($data['id']);

        if ($data["email"] != $user->email) {
            if (!$this->validateData($data, [
                'email' => 'required|valid_email|is_unique[auth_identities.secret]',
            ])) {
                $validation = \Config\Services::validation();

                return redirect()
                    ->to(base_url('admin/usermgt/update/') . $data["id"] . "#base")
                    ->with("redirectedErrorsBase", $validation->listErrors());
            }
        
            $user->fill([
                'email' => $data["email"]
            ]);
            $users->save($user);
        }

        // Add user to checked groups

        // First remove all groups

        $my_groups = $user->getGroups();

        foreach ($my_groups as $g) {
            $user->removeGroup($g);
        }

        $user->addGroup("user");

        // ... and add to checked groups

        $chk = $this->request->getPost('groups');

        if (!is_null($chk)) {
            foreach($chk as $c) {
                $user->addGroup($c);
            };
        }

        return redirect()->to(base_url('admin/usermgt/update/') . $data["id"] . "#base")->with('adminmessage', "Benutzerdaten geändert.");
    }

    public function user_mgt_update_sontaran_post(?int $id = null)
    {
        helper('form');

        $model_mail = model(SontaranMailRecip::class); 

        $data = $this->request->getPost(['mail', 'sont_level']);
        $users = auth()->getProvider();
        $user = $users->findById($id);

        $mail = $user->email;

        if (!is_null($data['mail'])) {
            if (!$this->validateData($data, [
                'sont_level' => 'required|integer',
            ])) {
                $validation = \Config\Services::validation();

                return redirect()
                    ->to(base_url('admin/usermgt/update/') . $id . "#sontaran")
                    ->with("redirectedErrorsSontaran", $validation->listErrors());
            }
            $model_mail->where(['mail' => $mail])->delete();
            $model_mail->save(['mail' => $mail, 'code' => $data["sont_level"]]);
        } else {
            $model_mail->where(['mail' => $mail])->delete();
        }

        return redirect()->to(base_url('admin/usermgt/update/') . $id . "#sontaran")->with('adminmessage_sont', "Benachrichtung aktualisiert.");
    }

    public function user_mgt_delete(?int $id = null)
    {
        $users = auth()->getProvider();
        $users->delete($id, true);

        return redirect()->to(base_url('admin/usermgt') . "#edit")->with('adminmessage_updateuser', "Benutzer gelöscht.");
    }
}
