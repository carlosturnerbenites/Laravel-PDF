<?php

namespace Tilume\PDF;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Contracts\Routing\ResponseFactory;

class PDF
{
    /**
     * @param Writer            $writer
     * @param ResponseFactory   $response
     * @param FilesystemManager $filesystem
     */
    public function __construct(
        Writer $writer,
        ResponseFactory $response,
        FilesystemManager $filesystem
    ) {
        $this->writer       = $writer;
        $this->response     = $response;
        $this->filesystem   = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function download($export, string $fileName)
    {
        $pdf = $this->export($export, $fileName);
        $pdf->render();
        $pdf->stream();
        // return $this->response->download($pdf->output(), $fileName);
    }

    /**
     * {@inheritdoc}
     */
    public function store($export, string $filePath, string $disk = null)
    {
        $file = $this->export($export, $filePath);
        return $this->filesystem->disk($disk)->put($filePath, $file->output());
    }

        /**
     * @param object      $export
     * @param string|null $fileName
     * @return string
     */
    protected function export($export, string $fileName)
    {
        return $this->writer->export($export);
    }
}
