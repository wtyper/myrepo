<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FileUploader
{
    private $targetDirectory;
    private $container;
    private $flashes;

    /**
     * FileUploader constructor.
     * @param $targetDirectory
     * @param SessionInterface $session
     */
    public function __construct($targetDirectory, SessionInterface $session)
    {
        $this->targetDirectory = $targetDirectory;
        $this->session = $session;
    }

    protected function addFlash(string $type, string $message)
    {
        if (!$this->session) {
            throw new \LogicException('You can not use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".');
        }
        $this->session->getFlashBag()->add($type, $message);
    }

    public function add(string $type, $message)
    {
        $this->flashes[$type][] = $message;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $safeFilename = transliterator_transliterate(
            'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        );
        $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();
        try {
            $file->move(
                $this->targetDirectory,
                $newFilename
            );
        } catch (FileException $e) {
            $errorMessage = $e->getMessage();
            $this->addFlash('error', $errorMessage);
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
