<?php

namespace Tilume\PDF;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;
use Laravel\Lumen\Application as LumenApplication;

class PDFServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('pdf');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('pdf.php'),
                ], 'config');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'pdf'
        );

        $this->app->bind('pdf', function () {
            return new PDF(
                $this->app->make(Writer::class),
                $this->app->make(ResponseFactory::class),
                $this->app->make('filesystem')
            );
        });

        $this->app->alias('pdf', PDF::class);
        $this->app->alias('pdf', Exporter::class);
    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'pdf.php';
    }
}
