<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;


class Form_download_ks extends BaseController
{
    public function download_forms($filename)
    {
        $staticPassword = 'BPSO@2024!';

        $password = $this->request->getGet('password');

        if ($password !== $staticPassword) {
            return redirect()->back()->with('error', 'Invalid password. Access denied.');
        }

        $filePath = FCPATH . 'uploads/forms/' . $filename;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    /*------------------------------------------------------------------------------------------------------------------------
	*	REMAP to prevent unauthorized method access
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
