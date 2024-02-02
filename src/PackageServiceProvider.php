<?php

namespace NormanHuth\HellofreshScraper;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->addAbout();
        }
    }

    /**
     * Add additional data to the output of the “about” command.
     */
    protected function addAbout(): void
    {
        $version = 'unknown';

        if (
            class_exists(InstalledVersions::class) &&
            method_exists(InstalledVersions::class, 'getAllRawData')
        ) {
            $installedVersions = InstalledVersions::getAllRawData();
            $version = data_get($installedVersions, '0.versions.norman-huth/hellofresh-scraper.pretty_version');
        }

        AboutCommand::add(
            'NormanHuth',
            fn () => ['norman-huth/hellofresh-scraper' => $version]
        );
    }
}
