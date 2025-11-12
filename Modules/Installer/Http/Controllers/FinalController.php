<?php

namespace Modules\Installer\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Installer\Entities\Utilities\EnvironmentManager;
use Modules\Installer\Entities\Utilities\FinalInstallManager;
use Modules\Installer\Entities\Utilities\InstalledFileManager;
use Modules\Installer\Events\LaravelInstallerFinished;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @param FinalInstallManager $finalInstall
     * @param EnvironmentManager $environment
     * @return Factory|View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {

        $dbMessage = [];
        if (!empty(session('message'))) {
            $dbMessage = session('message');
        }

        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('installer::final.index', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile', 'dbMessage'));
    }
}
