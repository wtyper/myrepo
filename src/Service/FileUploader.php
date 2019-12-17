<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    /**
     * FileUploader constructor.
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();
        try {
            $file->move(
                $this->targetDirectory,
                $newFilename
            );
        } catch (FileException $e) {
          $file->getErrorMessage();
        }
        return $newFilename;
    }
    /**
     * @param string $fileName
     * @return bool
     */
    public function delete(string $fileName): bool
    {
        return unlink($this->targetDirectory . '/' . $fileName);
    }
    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }


}