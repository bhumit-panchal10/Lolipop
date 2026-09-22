<?php

namespace App\Helpers;

class FileUploadHelper
{
    /**
     * Return document-root based upload path.
     */
    public static function uploadPath($folder = '')
    {
        $path = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        if (!empty($folder)) {
            $path .= '/' . trim($folder, '/');
        }

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    /**
     * Upload file with timestamp based filename.
     */
    public static function upload($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();

        $fileName = time() . '_' . uniqid() . '.' . $extension;

        $file->move(
            self::uploadPath($folder),
            $fileName
        );

        return $fileName;
    }

    /**
     * Delete uploaded file.
     */
    public static function delete($fileName, $folder)
    {
        if (empty($fileName)) {
            return;
        }

        $filePath = self::uploadPath($folder) . '/' . $fileName;

        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }
}
