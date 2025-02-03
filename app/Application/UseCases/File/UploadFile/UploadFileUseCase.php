<?php

namespace App\Application\UseCases\File\UploadFile;

use App\Repositories\File\FileRepository;

class UploadFileUseCase
{
    public function __construct(private FileRepository $fileRepository)
    {
    }

    /**
     * @param UploadFileInput[] $inputs
     * @return UploadFileOutput[]
     */
    public function execute(array $inputs): array
    {
        $result = [];

        foreach ($inputs as $input) {
            $fileMimeType = $input->file->getClientOriginalExtension();
            $fileName = sprintf('%s-%s.%s', uniqid(), time(), $fileMimeType);
            $filePath = $input->file->storeAs($input->directory, $fileName, 'public');

            $fileModel = $this->fileRepository->create([
                'name' => $input->file->getClientOriginalName(),
                'path' => $filePath,
                'sort' => $input->sort,
                'mime_type' => $fileMimeType,
            ]);

            $result[] = new UploadFileOutput($fileModel->id, $fileModel->path, $fileModel->name);
        }

        return $result;
    }
}