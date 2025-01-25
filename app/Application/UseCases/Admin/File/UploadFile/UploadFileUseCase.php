<?php

namespace App\Application\UseCases\Admin\File\UploadFile;

use App\Repositories\File\FileRepository;

class UploadFileUseCase
{
    public function __construct(private FileRepository $fileRepository)
    {
    }

    /**
     * @param UploadFileInput $input
     * @return UploadFileOutput[]
     */
    public function execute(UploadFileInput $input): array
    {
        $result = [];

        foreach ($input->files as $file) {
            $fileMimeType = $file->getClientOriginalExtension();
            $fileName = sprintf('%s-%s.%s', uniqid(), time(), $fileMimeType);
            $filePath = $file->storeAs($input->directory, $fileName, 'public');

            $fileModel = $this->fileRepository->create([
                'name' => $file->getClientOriginalName(),
                'path' => $filePath,
                'mime_type' => $fileMimeType,
            ]);

            $result[] = new UploadFileOutput($fileModel->id, $fileModel->path, $fileModel->name);
        }

        return $result;
    }
}