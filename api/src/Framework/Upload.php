<?php
namespace cavernos\bascode_api\Framework;

use Psr\Http\Message\UploadedFileInterface;

class Upload
{


    protected $path;

    protected $formats;

    public function __construct(?string $path = null)
    {
        if ($path) {
            $this->path = $path;
        }
    }

    public function upload(UploadedFileInterface $file, ?string $oldFile = null): string
    {

        $this->delete($oldFile);
        $targetPath = $this->addSuffix($this->path . '/' . $file->getClientFilename());
        $dirname = pathinfo($targetPath, PATHINFO_DIRNAME);
        if (!file_exists($dirname)) {
            mkdir($dirname, 777, true);
        }
        $file->moveTo($targetPath);
        return pathinfo($targetPath)['basename'];
    }

    private function addSuffix(string $targetPath)
    {
        if (file_exists($targetPath)) {
            $info = pathinfo($targetPath);
            $targetPath = $info['dirname'] . '/' . $info['filename'] . '_copy.' . $info['extension'];
            return $this->addSuffix($targetPath);
        }
        return $targetPath;
    }

    private function delete(?string $oldFile): void
    {
        if ($oldFile) {
            $oldFile = $this->path . '/' . $oldFile;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    }
}
