<?php echo $this->extend('layouts/layouts_user') ?>

<?php echo $this->section('navbar') ?>
<?php echo $this->include('partials/navbar_user') ?>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News | Announcement</title>
    <style>
        :root {
            --primary-color: #0d6efd;
            --danger-color: #dc3545;
            --success-color: #198754;
            --border-color: #dee2e6;
        }
        .news-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .preview-card {
            border: 1px solid var(--border-color);
            border-radius: 5px;
            overflow: hidden;
            position: relative;
            transition: transform 0.2s;
        }

        .preview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .preview-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
            background-color: #f8f9fa;
        }

        .preview-document {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
            background-color: #e9ecef;
            font-size: 3rem;
        }

        .preview-filename {
            padding: 8px;
            font-size: 0.8rem;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            background: white;
        }

        .delete-preview {
            position: absolute;
            top: 5px;
            right: 5px;
            background: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            color: var(--danger-color);
            z-index: 10;
        }

        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            background: #f8f9fa;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
            background-color: #e9f0ff;
        }

        .file-upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .attachment-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .existing-attachment {
            position: relative;
            transition: all 0.2s;
        }

        .existing-attachment:hover {
            transform: translateY(-3px);
        }

        .delete-attachment {
            position: absolute;
            top: 5px;
            right: 5px;
            background: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--danger-color);
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .delete-attachment:hover {
            background: var(--danger-color);
            color: white;
        }

        .status-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .status-new {
            background: var(--primary-color);
            color: white;
        }

        .status-existing {
            background: var(--success-color);
            color: white;
        }
    </style>
</head>

<body>
    <main class="py-4">
        <div class="container">
            <div class="news-container">
                <h1 class="mb-4"><?= esc($title) ?></h1>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Please fix the following errors:</h5>
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session('success')) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('bpso/news/update/' . $news['id']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>"
                            id="title" name="title" value="<?= old('title', esc($news['title'])) ?>">
                        <?php if (session()->has('errors.title')): ?>
                            <div class="invalid-feedback"><?= esc(session('errors.title')) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea class="form-control <?= session('errors.content') ? 'is-invalid' : '' ?>"
                            id="content" name="content" rows="6"><?= old('content', esc($news['content'])) ?></textarea>
                        <?php if (session()->has('errors.content')): ?>
                            <div class="invalid-feedback"><?= esc(session('errors.content')) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Add New Attachments</label>
                        <div class="form-text mb-2">
                            Max 10MB per file. Allowed: images (PNG, JPG, JPEG, GIF) and PDFs
                        </div>

                        <div class="file-upload-area" id="drop-area">
                            <div class="file-upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <h5>Drag & Drop files here</h5>
                            <p class="text-muted">or click to browse</p>
                            <input type="file" class="d-none" name="attachments[]" multiple id="attachments-input">
                        </div>

                        <div class="preview-container" id="preview-container"></div>

                        <?php if (session()->has('errors.attachments')): ?>
                            <div class="text-danger mt-2"><?= esc(session('errors.attachments')) ?></div>
                        <?php endif; ?>
                        <?php if (session()->has('errors.attachments.*')): ?>
                            <div class="text-danger mt-2"><?= esc(session('errors.attachments.*')) ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($news['attachments'])): ?>
                        <div class="attachment-section">
                            <h5 class="fw-bold mb-3">Existing Attachments</h5>
                            <div class="preview-container">
                                <?php foreach ($news['attachments'] as $index => $attachment): ?>
                                    <div class="preview-card existing-attachment">
                                        <span class="status-badge status-existing">Existing</span>

                                        <?php if ($attachment['file_type'] === 'image'): ?>
                                            <img src="<?= base_url('writable/uploads/news_attachments/' . $attachment['saved_name']) ?>"
                                                alt="<?= esc($attachment['original_name']) ?>"
                                                class="preview-image">
                                        <?php else: ?>
                                            <div class="preview-document">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="preview-filename"><?= esc($attachment['original_name']) ?></div>

                                        <a href="<?= base_url('bpso/news/delete_attachment/' . $news['id'] . '/' . $index) ?>"
                                            class="delete-attachment"
                                            onclick="return confirm('Are you sure you want to delete this attachment?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mt-5">
                        <div>
                            <a href="<?= base_url('bpso/news') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>

                            <button type="button" class="btn btn-danger ms-2"
                                onclick="confirmDelete()">
                                <i class="bi bi-trash me-1"></i> Delete News | Announcements
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update News | Announcements
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this news item? This action cannot be undone.</p>
                            <p class="fw-bold">All associated attachments will also be deleted.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="<?= base_url('bpso/news/delete/' . $news['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger">Delete Permanently</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dropArea = document.getElementById('drop-area');
                    const fileInput = document.getElementById('attachments-input');
                    const previewContainer = document.getElementById('preview-container');
                    const filesToUpload = [];

                    dropArea.addEventListener('click', () => fileInput.click());

                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        dropArea.addEventListener(eventName, preventDefaults, false);
                    });

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    ['dragenter', 'dragover'].forEach(eventName => {
                        dropArea.addEventListener(eventName, highlight, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        dropArea.addEventListener(eventName, unhighlight, false);
                    });

                    function highlight() {
                        dropArea.style.borderColor = '#0d6efd';
                        dropArea.style.backgroundColor = '#e9f0ff';
                    }

                    function unhighlight() {
                        dropArea.style.borderColor = '#dee2e6';
                        dropArea.style.backgroundColor = '#f8f9fa';
                    }

                    dropArea.addEventListener('drop', handleDrop, false);

                    function handleDrop(e) {
                        const dt = e.dataTransfer;
                        const files = dt.files;
                        handleFiles(files);
                    }

                    fileInput.addEventListener('change', function() {
                        handleFiles(this.files);
                    });

                    function handleFiles(files) {
                        [...files].forEach(file => {
                            if (!filesToUpload.some(f => f.name === file.name && f.size === file.size)) {
                                filesToUpload.push(file);
                                previewFile(file);
                            }
                        });

                        updateFileInput();
                    }

                    function previewFile(file) {
                        const reader = new FileReader();
                        const previewCard = document.createElement('div');
                        previewCard.className = 'preview-card';

                        const statusBadge = document.createElement('span');
                        statusBadge.className = 'status-badge status-new';
                        statusBadge.textContent = 'New';
                        previewCard.appendChild(statusBadge);

                        if (file.type.startsWith('image/')) {
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'preview-image';
                                previewCard.appendChild(img);
                                addFilenameAndDelete(file, previewCard);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            const docIcon = document.createElement('div');
                            docIcon.className = 'preview-document';
                            docIcon.innerHTML = '<i class="bi bi-file-earmark-pdf"></i>';
                            previewCard.appendChild(docIcon);
                            addFilenameAndDelete(file, previewCard);
                        }

                        previewContainer.appendChild(previewCard);
                    }

                    function addFilenameAndDelete(file, container) {
                        const filename = document.createElement('div');
                        filename.className = 'preview-filename';
                        filename.textContent = file.name;
                        container.appendChild(filename);

                        const deleteBtn = document.createElement('div');
                        deleteBtn.className = 'delete-preview';
                        deleteBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                        deleteBtn.onclick = () => removePreview(container, file);
                        container.appendChild(deleteBtn);
                    }

                    function removePreview(previewElement, file) {
                        previewElement.remove();

                        const index = filesToUpload.findIndex(f =>
                            f.name === file.name && f.size === file.size
                        );

                        if (index !== -1) {
                            filesToUpload.splice(index, 1);
                            updateFileInput();
                        }
                    }

                    function updateFileInput() {
                        const dataTransfer = new DataTransfer();
                        filesToUpload.forEach(file => dataTransfer.items.add(file));
                        fileInput.files = dataTransfer.files;

                        if (filesToUpload.length > 0) {
                            dropArea.querySelector('h5').textContent = 'Add more files';
                            dropArea.querySelector('p').textContent = 'Drag & drop or click to add';
                        } else {
                            dropArea.querySelector('h5').textContent = 'Drag & Drop files here';
                            dropArea.querySelector('p').textContent = 'or click to browse';
                        }
                    }
                });

                function confirmDelete() {
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                }
            </script>
        </div>
    </main>
</body>

</html>
<?php echo $this->endSection() ?>