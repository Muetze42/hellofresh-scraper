<?php

namespace NormanHuth\HellofreshScraper\Providers;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * The name of the composer package.
     */
    protected string $packageName = 'norman-huth/hellofresh-scraper';

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
            $this->aboutCommand();
        }
    }

    /**
     * Add additional data to the output of the 'about' command.
     */
    protected function aboutCommand(): void
    {
        AboutCommand::add($this->packageName, fn () => [
            'Version' => $this->getPackageVersion(),
            'Source' => 'https://github.com/' . $this->packageName,
        ]);
    }

    /**
     * Get installed version of this package.
     *
     * @return string
     */
    protected function getPackageVersion(): string
    {
        if (InstalledVersions::isInstalled($this->packageName)) {
            if ($version = InstalledVersions::getVersion($this->packageName)) {
                return $version;
            }
        }

        return 'unknown';
    }
}
