<?php

namespace Modules\Settings\Http\Controllers\Dashboard;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\HtmlString;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Settings\Http\Requests\SettingRequest;
use Modules\Settings\Notifications\TestMail;
use Notification;

class SettingController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The list of the files keys.
     *
     * @var array
     */
    protected $files = [
        'logo',
        'favicon',
        'loginLogo',
        'loginBackground',
        'cover',
    ];


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:read_settings')->only(['index', 'shipping']);
        $this->middleware('permission:create_settings')->only(['create', 'store']);
        $this->middleware('permission:update_settings')->only(['edit', 'update']);
        $this->middleware('permission:delete_settings')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        if (!$tab = request('tab')) {
            return redirect()->route('dashboard.settings.index', ['tab' => 'main']);
        }

        if (!view()->exists($view = "settings::settings.tabs.$tab")) {
            abort(404);
        }

        return view($view);
    }

    /**
     * Update the specified resource in storage.
     * @param SettingRequest $request
     * @return RedirectResponse
     */
    public function update(SettingRequest $request)
    {
        foreach ($request->except(
            array_merge(['_token', '_method', 'media', 'phones'], $this->files)
        )
            as $key => $value) {
            Settings::set($key, $value);
        }

        foreach ($this->files as $file) {
            if ($request->hasFile($file)) {
                Settings::instance($file)->clearMediaCollection($file);
                Settings::instance($file)->addMediaFromRequest($file)->toMediaCollection($file);
            }
        }

        if ($request->phones) {
            $phones = array();
            foreach ($request->phones as $key => $value) {
                $phones[] = $value['phone'];
            }
            Settings::set("phones", $phones);
        }

        $this->changeEnvironmentVariable('MAIL_MAILER', Settings::get('mail_driver'));
        $this->changeEnvironmentVariable('MAIL_HOST', Settings::get('mail_host'));
        $this->changeEnvironmentVariable('MAIL_PORT', Settings::get('mail_port'));
        $this->changeEnvironmentVariable('MAIL_USERNAME', Settings::get('mail_username'));
        $this->changeEnvironmentVariable('MAIL_PASSWORD', Settings::get('mail_password'));
        $this->changeEnvironmentVariable('MAIL_ENCRYPTION', Settings::get('mail_encryption'));
        $this->changeEnvironmentVariable('MAIL_FROM_ADDRESS', Settings::get('mail_from_address'));
        $this->changeEnvironmentVariable('MAIL_FROM_NAME', Settings::get('mail_from_name'));

        flash(trans('settings::settings.messages.updated'))->success();

        return redirect()->back();
    }



    function changeEnvironmentVariable($key, $value)
    {
        $path = base_path('.env');

        if (is_bool(env($key))) {
            $old = env($key) ? 'true' : 'false';
        } elseif (env($key) === null) {
            $old = 'null';
        } else {
            $old = env($key);
        }

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . $old,
                "$key=" . $value,
                file_get_contents($path)
            ));
        }
    }



    // test mail
    public function testMail()
    {
        try {
            Notification::route('mail', Settings::get('mail_from_address'))->notify(new TestMail());

            // Mail::to('karimosama1041997@gmail.com')->send(new SubscribeMail());

            flash(trans('settings::settings.messages.test_mail_sent'))->success();
            return redirect()->back();
        } catch (\Exception $e) {
            $msg = '<b>Test mail has not been sent successfully, There is some problem in your mail settings</b> <br><br> The Error : <br>' . $e->getMessage();
            $msg = new HtmlString($msg);
            return redirect()->back()->with('error', $msg);
        }
    }



    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/' . $filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    public function pages()
    {
        return view('settings::settings.tabs.titles');
    }
}
