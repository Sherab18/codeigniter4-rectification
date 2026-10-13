<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class News extends BaseController
{
    protected $model;
    protected $session;


    public function __construct()
    {
        helper(['form', 'date', 'database', 'file']);
        $this->session = session();
        $this->model = new NewsModel();
    }

    public function index()
    {
        $news = $this->model->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'news' => array_map(function ($item) {
                $item['attachments'] = $item['attachments'] ? json_decode($item['attachments'], true) : [];
                return $item;
            }, $news),
            'title' => 'News | Announcements'
        ];

        return view('news/index', $data);
    }

    public function new()
    {
         $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $data = [
            'title' => 'Create News & Announcements'
        ];
        return view('news/create', $data);
    }

    public function create()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];
        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $validationRules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'attachments' => [
                'label' => 'Attachments',
                'rules' => 'max_size[attachments,10240]',
                'errors' => [
                    'max_size' => 'Total attachment size exceeds 10MB limit'
                ]
            ],
            'attachments.*' => [
                'label' => 'Attachment',
                'rules' => 'if_exist|uploaded[attachments]|max_size[10240]|mime_in[attachments,image/jpeg,image/png,image/gif,application/pdf]|ext_in[attachments,png,jpg,jpeg,gif,pdf]',
                'errors' => [
                    'uploaded' => 'File upload failed for {field}',
                    'mime_in' => 'Invalid file type for {field}',
                    'ext_in' => 'Only images and PDFs are allowed for {field}'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $attachments = $this->processAttachments();

        $data = [
            'title' => esc($this->request->getPost('title')),
            'content' => esc($this->request->getPost('content')),
            'attachments' => $attachments ? json_encode($attachments) : null
        ];

        try {
            if ($this->model->save($data)) {
                return redirect()->to('/bpso/news')->with('success', 'News created successfully!');
            } else {
                $error = $this->model->errors() ? implode(' ', $this->model->errors()) : 'Unknown database error';
                return redirect()->back()->withInput()->with('error', 'Failed to create news item: ' . $error);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Server error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];
        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $news = $this->model->find($id);

        if (!$news) {
            return redirect()->to('/bpso/news')->with('error', 'News not found');
        }

        $news['attachments'] = $news['attachments'] ? json_decode($news['attachments'], true) : [];

        $data = [
            'news' => $news,
            'title' => 'Edit News | Announcements'
        ];

        return view('news/edit', $data);
    }

    public function update($id)
    {
        $news = $this->model->find($id);

        if (!$news) {
            return redirect()->to('/bpso/news')->with('error', 'News not found');
        }

        $validationRules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'attachments' => 'max_size[attachments,10240]',
            'attachments.*' => [
                'label' => 'Attachment',
                'rules' => 'if_exist|uploaded[attachments]|max_size[10240]|mime_in[attachments,image/jpeg,image/png,image/gif,application/pdf]|ext_in[attachments,png,jpg,jpeg,gif,pdf]',
                'errors' => [
                    'mime_in' => 'Invalid file type for {field}',
                    'ext_in' => 'Only images and PDFs are allowed for {field}'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existingAttachments = $news['attachments'] ? json_decode($news['attachments'], true) : [];
        $newAttachments = $this->processAttachments();
        $allAttachments = array_merge($existingAttachments, $newAttachments);

        $data = [
            'id' => $id,
            'title' => esc($this->request->getPost('title')),
            'content' => esc($this->request->getPost('content')),
            'attachments' => $allAttachments ? json_encode($allAttachments) : null
        ];

        if ($this->model->save($data)) {
            return redirect()->to('/bpso/news')->with('success', 'News updated successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update news item');
    }

    public function delete($id)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];
        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $news = $this->model->find($id);

        if (!$news) {
            return redirect()->to('/bpso/news')->with('error', 'News not found');
        }

        if ($news['attachments']) {
            $attachments = json_decode($news['attachments'], true);
            foreach ($attachments as $attachment) {
                $this->deleteAttachmentFile($attachment['saved_name']);
            }
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/bpso/news')->with('success', 'News deleted successfully!');
        }

        return redirect()->to('/bpso/news')->with('error', 'Failed to delete news item');
    }

    public function delete_attachment($newsId, $attachmentIndex)
    {
        $news = $this->model->find($newsId);

        if (!$news) {
            return redirect()->to('/bpso/news')->with('error', 'News not found');
        }

        $attachments = $news['attachments'] ? json_decode($news['attachments'], true) : [];

        if (isset($attachments[$attachmentIndex])) {
            $attachment = $attachments[$attachmentIndex];
            $this->deleteAttachmentFile($attachment['saved_name']);
            unset($attachments[$attachmentIndex]);
            $attachments = array_values($attachments);

            $this->model->update($newsId, ['attachments' => json_encode($attachments)]);
            return redirect()->to('/bpso/news/edit/' . $newsId)->with('success', 'Attachment deleted successfully');
        }

        return redirect()->to('/bpso/news/edit/' . $newsId)->with('error', 'Attachment not found');
    }

    public function serve_attachment($fileName)
    {
        $filePath = WRITEPATH . 'uploads/news_attachments/' . $fileName;

        if (!file_exists($filePath)) {
            log_message('error', "Attachment not found: {$fileName}");
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($filePath);
        $mime = $mime ?: 'application/octet-stream';

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($filePath));

        $disposition = strpos($mime, 'image/') === 0 ? 'inline' : 'attachment';
        header('Content-Disposition: ' . $disposition . '; filename="' . basename($filePath) . '"');

        readfile($filePath);
        exit;
    }


    private function processAttachments()
    {
        $files = $this->request->getFiles();
        $attachments = [];

        if ($files && isset($files['attachments'])) {
            $uploadPath = WRITEPATH . 'uploads/news_attachments/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($files['attachments'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();

                    if ($file->move($uploadPath, $newName)) {
                        $fileType = $file->getClientMimeType();

                        $attachments[] = [
                            'original_name' => $file->getClientName(),
                            'saved_name' => $newName,
                            'file_type' => strpos($fileType, 'image/') === 0 ? 'image' : 'pdf'
                        ];
                    }
                }
            }
        }

        return $attachments;
    }

    private function deleteAttachmentFile($fileName)
    {
        $filePath = WRITEPATH . 'uploads/news_attachments/' . $fileName;

        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
            return true;
        }

        return false;
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
