<?php

namespace Modules\Installer\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Installer\Entities\Utilities\EnvironmentManager;
use Modules\Installer\Events\EnvironmentSaved;
use Validator;

class EnvironmentController extends Controller
{
    /**
     * @var EnvironmentManager
     */
    protected $EnvironmentManager;

    /**
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(EnvironmentManager $environmentManager)
    {
        $this->EnvironmentManager = $environmentManager;
    }

    /**
     * Display the Environment menu page.
     *
     * @return View
     */
    public function environmentMenu()
    {
        return view('installer::environment.index');
    }

    /**
     * Display the Environment page.
     *
     * @return View
     */
    public function environmentWizard()
    {
        $envConfig = $this->EnvironmentManager->getEnvContent();

        return view('installer::environment.environment-wizard', compact('envConfig'));
    }

    /**
     * Display the Environment page.
     *
     * @return View
     */
    public function environmentClassic()
    {
        $envConfig = $this->EnvironmentManager->getEnvContent();

        return view('installer::environment.environment-classic', compact('envConfig'));
    }

    /**
     * Processes the newly saved environment configuration (Classic).
     *
     * @param Request $input
     * @param Redirector $redirect
     * @return RedirectResponse
     */
    public function saveClassic(Request $input, Redirector $redirect)
    {
        $message = $this->EnvironmentManager->saveFileClassic($input);

        event(new EnvironmentSaved($input));

        return $redirect->route('installer.environmentClassic')
            ->with(['message' => $message]);
    }

    // Save old values to sessions
    public function rememberOldRequest($request)
    {
        foreach ($request->all() as $field => $value) {
            session(['_old_input.' . $field => $value]);
        }
    }

    /**
     * Processes the newly saved environment configuration (Form Wizard).
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return RedirectResponse
     */
    public function saveWizard(Request $request, Redirector $redirect)
    {
        $envConfig = $this->EnvironmentManager->getEnvContent();

        $rules = config('installer.environment.form.rules');
        $messages = [
            'environment_custom.required_if' => trans('installer::installer.environment.wizard.form.name_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($request->app_force_https == 'true') {
            $request->merge(['app_url' => 'https://' . $request->app_domain]);
        } else {
            $request->merge(['app_url' => 'http://' . $request->app_domain]);
        }

        $this->rememberOldRequest($request);

        if ($validator->fails()) {
            return $redirect->route('installer.environmentWizard')->withInput()->withErrors($validator->errors());
        }

        if (!$this->checkDatabaseConnection($request)) {

            $this->rememberOldRequest($request);

            return $redirect->route('installer.environmentWizard')->withInput()->withErrors([
                'database_connection' => trans('installer::installer.environment.wizard.form.db_connection_failed'),
            ]);
        }

        $results = $this->EnvironmentManager->saveFileWizard($request);

        event(new EnvironmentSaved($request));

        return $redirect->route('installer.database')
            ->with(['results' => $results]);
    }

    /**
     * Validate database connection with user credentials (Form Wizard).
     *
     * @param Request $request
     * @return bool
     */
    private function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('database_connection');

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
