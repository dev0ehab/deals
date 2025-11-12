<?php

namespace Modules\Installer\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Installer\Entities\Utilities\RequirementsChecker;

class RequirementsController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected RequirementsChecker $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return View
     */
    public function index(): View
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(
            config('installer.core.minPhpVersion')
        );
        $requirements = $this->requirements->check(
            config('installer.requirements')
        );

        return view('installer::requirements.index', compact('requirements', 'phpSupportInfo'));
    }
}
