<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoginModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;


class Users extends BaseController
{
	protected $session;

	public function __construct()
	{
		helper(['form', 'date', 'database']);

		$this->session = \Config\Services::session();
	}
	public function register()
	{
		return view('users/register_start');
	}

	public function create()
	{
		$model = new UserModel();

		if ($this->validate([
			'given_name' => 'required|min_length[2]|max_length[50]',
			'last_name'  => 'required|min_length[2]|max_length[50]',
			'sex'        => 'required',
			'mobile'     => 'required|min_length[8]|max_length[8]|regex_match[/^[0-9]+$/]',
			'email'      => 'required|valid_email',
			'password'   => 'required|min_length[8]',
			'confirm_pass' => 'required|matches[password]',
		])) {
			$model->save([
				'given_name' => $this->request->getVar('given_name'),
				'last_name'  => $this->request->getVar('last_name'),
				'sex'        => $this->request->getVar('sex'),
				'mobile'     => $this->request->getVar('mobile'),
				'email'      => $this->request->getVar('email'),
				'password'   => $this->request->getVar('password'),
				'created_at' => date('Y-m-d H:i:s'),
				'status'     => 'inactive'
			]);

			return redirect()->to('/users/login')->with('success', 'Registration successful. You can now log in.');
		} else {
			return view('users/register_start', [
				'validation' => $this->validator,
			]);
		}
	}
	public function login()
	{
		return view('users/login_page');
	}

	public function loginProcess()
	{
		helper('reCAPTCHA_helper');

		$userModel = new UserModel();
		$loginModel = new LoginModel();

		$email = $this->request->getVar('email');
		$password = $this->request->getVar('password');
		$remoteIp = $this->request->getIPAddress();
		$recaptchaResponse = $this->request->getPost('g-recaptcha-response');

		if (!verifyCaptcha($remoteIp, $recaptchaResponse)) {
			return redirect()->back()->with('error', 'reCAPTCHA verification failed. Please try again.');
		}


		if (!$this->validate([
			'email' => 'required|valid_email',
			'password' => 'required',
		])) {
			return view('users/login_page', [
				'validation' => $this->validator,
			]);
		}

		$user = $userModel->where('email', $email)->first();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				if ($user['status'] === 'active') {
					$this->session->set('login_info', [
						'user_id' => $user['id'],
						'unit_id' => $user['unit_id'],
						'email' => $user['email'],
						'name' => $user['given_name'],
						'avatar'     => $user['avatar'] ?? null,
						'isLoggedIn' => true,
					]);

					log_message('debug', 'Session Data after login: ' . print_r($this->session->get(), true));
					$loginModel->save([
						'id' => uniqid(),
						'user_id' => $user['id'],
						'user_agent' => $this->request->getUserAgent(),
						'user_ip' => $this->request->getIPAddress(),
						'login_time' => date('Y-m-d H:i:s'),
					]);

					return redirect()->to('/powerdata/list_energy')->with('success', 'Logged in successfully.');
				} else {
					return redirect()->back()->with('error', 'Your account is not activated. Please contact administrator at KEZANG SHERAB.');
				}
			} else {
				return redirect()->back()->with('error', 'Invalid email or password.');
			}
		} else {
			return redirect()->back()->with('error', 'Invalid email or password.');
		}
	}

	public function logout()
	{
		$loginModel = new LoginModel();

		// Read user_id from login_info array
		$loginInfo = $this->session->get('login_info');
		$userId    = $loginInfo['user_id'] ?? null;

		if ($userId) {
			$loginModel->where('user_id', $userId)
				->where('logout_time', null)
				->set('logout_time', date('Y-m-d H:i:s'))
				->update();
		}

		$this->session->destroy();

		return redirect()->to('/users/login')->with('success', 'Logged out successfully.');
	}
	/*------------------------------------------------------------------------------------------------------------------------
	* REMAP to prevent unauthorized method access
	*/
	public function _remap($method, $param1 = null, $param2 = null)
	{
		if (method_exists($this, $method)) {
			return $this->$method($param1, $param2);
		} else {
			throw PageNotFoundException::forPageNotFound();
		}
	}
}
