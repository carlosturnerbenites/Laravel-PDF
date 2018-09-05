<?php
namespace Tilume\PDF\Concerns;

use Tilume\PDF\PDF;
use Tilume\PDF\Exceptions\NoFilenameGivenException;
use Tilume\PDF\Exceptions\NoFilePathGivenException;

trait Exportable
{
    /**
     * @param string      $fileName
     *
     * @throws NoFilenameGivenException
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(string $fileName = null)
    {
        $fileName = $fileName ?? $this->fileName ?? null;
        if (null === $fileName) {
            throw new NoFilenameGivenException();
        }
        return resolve(PDF::class)->download($this, $fileName);
    }
    /**
     * @param string      $filePath
     * @param string|null $disk
     *
     * @throws NoFilePathGivenException
     * @return bool
     */
    public function store(string $filePath = null, string $disk = null)
    {
        $filePath = $filePath ?? $this->filePath ?? null;
        if (null === $filePath) {
            throw new NoFilePathGivenException();
        }
        return resolve(PDF::class)->store(
            $this,
            $filePath,
            $disk ?? $this->disk ?? null
        );
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @throws NoFilenameGivenException
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return $this->download();
    }
}
