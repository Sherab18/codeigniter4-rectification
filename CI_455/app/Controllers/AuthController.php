<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function changePassword()
    {
        return view('auth/change_password');
    }

    public function updatePassword()
    {
        $loginInfo = session()->get('login_info');
        $userId    = $loginInfo['user_id'] ?? null;

        if (!$userId) {
            return redirect()->back()->with('error', 'Session expired. Please log in again.');
        }

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User record not found in the database.');
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $userModel->update($userId, [
            'password' => $this->request->getPost('new_password')
        ]);

        return redirect()->to('auth/change-password')->with('success', 'Password updated successfully!');
    }
    public function editProfile()
    {
        $loginInfo = session()->get('login_info');
        $userId    = $loginInfo['user_id'] ?? null;

        if (!$userId) {
            return redirect()->to('users/login')->with('error', 'Session expired. Please log in again.');
        }

        $userModel = new UserModel();
        $data['user'] = $userModel->find($userId);

        return view('auth/edit_profile', $data);
    }

    public function updateProfile()
    {
        $loginInfo = session()->get('login_info');
        $userId    = $loginInfo['user_id'] ?? null;

        if (!$userId) {
            return redirect()->to('users/login')->with('error', 'Session expired. Please log in again.');
        }

        // 1. Validation Rules (including avatar rules)
        $rules = [
            'given_name' => 'required|min_length[2]|max_length[50]',
            'last_name'  => 'required|min_length[2]|max_length[50]',
            'sex'        => 'required',
            'mobile'     => 'required|min_length[8]|max_length[8]|regex_match[/^[0-9]+$/]',
            'email'      => 'required|valid_email',
            'avatar'     => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        $updateData = [
            'given_name' => $this->request->getPost('given_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'sex'        => $this->request->getPost('sex'),
            'mobile'     => $this->request->getPost('mobile'),
            'email'      => $this->request->getPost('email'),
        ];

        // 2. Handle File Upload
        $file = $this->request->getFile('avatar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate random name to prevent caching/overwrites
            $newName = $file->getRandomName();

            // Move to public/assets/uploads/avatars/
            $file->move(FCPATH . 'assets/uploads/avatars/', $newName);
            // Resize uploaded image to 200x200 and crop to square
            \Config\Services::image()
                ->withFile(FCPATH . 'assets/uploads/avatars/' . $newName)
                ->fit(200, 200, 'center')
                ->save(FCPATH . 'assets/uploads/avatars/' . $newName);

            // Delete previous custom avatar if it exists
            if (!empty($user['avatar']) && file_exists(FCPATH . 'assets/uploads/avatars/' . $user['avatar'])) {
                unlink(FCPATH . 'assets/uploads/avatars/' . $user['avatar']);
            }

            $updateData['avatar'] = $newName;
            $loginInfo['avatar']  = $newName; // Keep session synced
        }

        // 3. Update Record & Session
        $userModel->update($userId, $updateData);

        $loginInfo['name']  = $this->request->getPost('given_name');
        $loginInfo['email'] = $this->request->getPost('email');
        session()->set('login_info', $loginInfo);

        return redirect()->to('auth/edit-profile')->with('success', 'Profile and avatar updated successfully!');
    }
}
