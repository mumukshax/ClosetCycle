<?php

class ImageUpload
{
    private const MAX_SIZE = 5242880; // 5 MB


    // Save an uploaded listing image.
    // Returns a filename or an error message.
    public static function save($file)
    {
        // No image was selected.
        if (
            !$file ||
            !isset($file['error']) ||
            $file['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return [
                'fileName' => null,
                'error' => null
            ];
        }


        // Make sure PHP received the upload correctly.
        if ($file['error'] !== UPLOAD_ERR_OK) {

            return [
                'fileName' => null,
                'error' =>
                    'The image could not be uploaded.'
            ];
        }


        // Limit file size to 5 MB.
        if ($file['size'] > self::MAX_SIZE) {

            return [
                'fileName' => null,
                'error' =>
                    'The image must be 5 MB or smaller.'
            ];
        }


        // Check the actual MIME type of the file.
        $fileInfo =
            new finfo(FILEINFO_MIME_TYPE);

        $mimeType =
            $fileInfo->file(
                $file['tmp_name']
            );


        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        ];


        if (
            !array_key_exists(
                $mimeType,
                $allowedTypes
            )
        ) {

            return [
                'fileName' => null,
                'error' =>
                    'Please upload a JPG, PNG, or WebP image.'
            ];
        }


        $extension =
            $allowedTypes[$mimeType];


        // Generate a unique filename instead of
        // trusting the user's original filename.
        $fileName =
            'item_' .
            bin2hex(
                random_bytes(8)
            ) .
            '.' .
            $extension;


        $destination =
            __DIR__ .
            '/../public/uploads/' .
            $fileName;


        if (
            !move_uploaded_file(
                $file['tmp_name'],
                $destination
            )
        ) {

            return [
                'fileName' => null,
                'error' =>
                    'The image could not be saved.'
            ];
        }


        return [
            'fileName' => $fileName,
            'error' => null
        ];
    }


    // Delete an uploaded image when it is
    // no longer being used by a listing.
    public static function delete($fileName)
    {
        if (
            !$fileName ||
            $fileName === 'default-item.png'
        ) {
            return;
        }


        $path =
            __DIR__ .
            '/../public/uploads/' .
            basename($fileName);


        if (is_file($path)) {
            unlink($path);
        }
    }
}