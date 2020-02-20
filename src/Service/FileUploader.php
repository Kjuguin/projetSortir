<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

// Classe qui permet d'upload un fichier dans notre projet en le renommant dans un format utilisable
// Le TargetDirectory est configuré dans services.yaml pour pointer vers notre directory stockant les fichiers upload
class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $this->getTargetDirectory().'/'.$fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}