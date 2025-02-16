<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Store a file from a web-form to the sorage
     */
    public static function storeFile($file, string $disk = 'grch', string $folder = 'uploads')
    {
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $fileName, $disk);

        return $fileName;
    }

    /**
     * Delete a file by name
     *
     * @param string $fileName
     * @param string $disk
     * @return array
     */
    public static function deleteFile(string $fileName, string $disk = 'grch'): array
    {
        $filePath = "uploads/{$fileName}";

        // Check if the file exists
        if (!Storage::disk($disk)->exists($filePath)) {
            return [
                'success' => false,
                'message' => "Файл '{$fileName}' не найден.",
                'status' => 404,
            ];
        }

        // Delete the file
        if (Storage::disk($disk)->delete($filePath)) {
            return [
                'success' => true,
                'message' => "Файл '{$fileName}' успешно удалён.",
                'status' => 200,
            ];
        }

        return [
            'success' => false,
            'message' => "Не удалось удалить файл '{$fileName}'.",
            'status' => 500,
        ];
    }
}
