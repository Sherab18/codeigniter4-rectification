<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Form_download_ks extends BaseController
{
    public function download_forms($filename = null)
    {
        if (empty($filename)) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 1. Retrieve secret securely from environment configuration
        $expectedPassword = (string) env('FORM_DOWNLOAD_PASSWORD', 'BPSO@2024!');
        $userPassword = (string) ($this->request->getGet('password') ?? '');

        // 2. Perform constant-time string comparison to prevent timing attacks
        if (!hash_equals($expectedPassword, $userPassword)) {
            return redirect()->back()->with('error', 'Invalid password. Access denied.');
        }

        // 3. Sanitize filename to prevent Directory Traversal attacks (CWE-22)
        $cleanFilename = basename($filename);
        $filePath = FCPATH . 'uploads/forms/' . $cleanFilename;

        // Verify file existence and ensure path remains strictly inside the target directory
        if (is_file($filePath) && file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /*------------------------------------------------------------------------------------------------------------------------
	*	REMAP to prevent unauthorized method access
	*/
    public function _remap($method, $param1 = null, $param2 = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param1, $param2);
        }

        throw PageNotFoundException::forPageNotFound();
    }
}