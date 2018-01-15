<?php

namespace Ridoy\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Ridoy\LaravelInstaller\Helpers\EnvironmentManager;
use Ridoy\LaravelInstaller\Helpers\FinalInstallManager;
use Ridoy\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
