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
    <title>Create News & Announcement</title>
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
    </style>
</head>

<body>
    <main class="py-4">
        <div class="container">
            <div class="news-container">
                <h1 class="mb-4"><?= esc($title) ?></h1>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Please veirfy the restrictions:</h5>
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

                <form method="post" action="<?= base_url('bpso/news/create') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>"
                            id="title" name="title" value="<?= old('title', '') ?>">
                        <?php if (session()->has('errors.title')): ?>
                            <div class="invalid-feedback"><?= esc(session('errors.title')) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea class="form-control <?= session('errors.content') ? 'is-invalid' : '' ?>"
                            id="content" name="content" rows="6"><?= old('content', '') ?></textarea>
                        <?php if (session()->has('errors.content')): ?>
                            <div class="invalid-feedback"><?= esc(session('errors.content')) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Attachments</label>
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

                        <?php if ($attachmentErrors = session('errors.attachments') ?? session('errors.attachments.*')): ?>
                            <div class="text-danger mt-2">
                                <?php if (is_array($attachmentErrors)): ?>
                                    <?= esc(implode('<br>', $attachmentErrors)) ?>
                                <?php else: ?>
                                    <?= esc($attachmentErrors) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="<?= base_url('bpso/news') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Create News & Announcement
                        </button>
                    </div>
                </form>
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

                        if (file.type.startsWith('image/')) {
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'preview-image';
                                img.alt = 'Preview: ' + file.name;
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
            </script>
        </div>
    </main>
</body>

</html>
<?php echo $this->endSection() ?>