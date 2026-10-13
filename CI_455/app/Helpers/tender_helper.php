<?php
if (!function_exists('getFileIcon')) {
    function getFileIcon($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $iconClass = 'bi-file-earmark';

        $icons = [
            'pdf'  => 'bi-file-earmark-pdf text-danger',
            'xlsx' => 'bi-file-earmark-excel text-success',
            'xls'  => 'bi-file-earmark-excel text-success',
            'doc'  => 'bi-file-earmark-word text-primary',
            'docx' => 'bi-file-earmark-word text-primary',
            'txt'  => 'bi-file-earmark-text',
            'zip'  => 'bi-file-earmark-zip',
            'jpg'  => 'bi-file-earmark-image',
            'jpeg' => 'bi-file-earmark-image',
            'png'  => 'bi-file-earmark-image',
            'ppt'  => 'bi-file-earmark-ppt',
            'pptx' => 'bi-file-earmark-ppt',
        ];

        $extension = strtolower($extension);
        if (array_key_exists($extension, $icons)) {
            $iconClass = $icons[$extension];
        }

        return '<i class="bi ' . $iconClass . ' me-2"></i>';
    }
}
