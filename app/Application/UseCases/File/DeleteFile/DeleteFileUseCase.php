<?php

namespace App\Application\UseCases\File\DeleteFile;

use App\Events\File\FileDeleted;
use App\Models\File;
use App\Repositories\File\FileRepository;
use function event;

class DeleteFileUseCase
{
    public function __construct(private FileRepository $fileRepository)
    {
    }

    /**
     * @param DeleteFileInput[] $inputs
     * @return void
     */
    public function execute(array $inputs): void
    {
        foreach ($inputs as $input) {
            if ($file = File::find($input->id)) {
                event(new FileDeleted($file));
            }
            $this->fileRepository->delete($input->id);
        }
    }
}