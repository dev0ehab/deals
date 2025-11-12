<?php

use App\Enums\ServicesEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Orders\Entities\Order;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Modules\Accounts\Entities\User;
use Modules\Areas\Entities\Area;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Support\Traits\ApiTrait;


if (!function_exists('validate_base64')) {
    /**
     * Validate a base64 content.
     *
     * @param string $base64data
     * @param array $allowedMime example ['png', 'jpg', 'jpeg']
     * @return bool
     */
    function validate_base64($base64data, array $allowedMime)
    {
        // strip out data uri scheme information (see RFC 2397)
        if (strpos($base64data, ';base64') !== false) {
            [, $base64data] = explode(';', $base64data);
            [, $base64data] = explode(',', $base64data);
        }

        // strict mode filters for non-base64 alphabet characters
        if (base64_decode($base64data, true) === false) {
            return false;
        }

        // decoding and then reeconding should not change the data
        if (base64_encode(base64_decode($base64data)) !== $base64data) {
            return false;
        }

        $binaryData = base64_decode($base64data);

        // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);

        // guard Against Invalid MimeType
        $allowedMime = Arr::flatten($allowedMime);

        // no allowedMimeTypes, then any type would be ok
        if (empty($allowedMime)) {
            return true;
        }

        // Check the MimeTypes
        $validation = Illuminate\Support\Facades\Validator::make(
            ['file' => new Illuminate\Http\File($tmpFile)],
            ['file' => 'mimes:' . implode(',', $allowedMime)]
        );

        return !$validation->fails();
    }
}

if (!function_exists('random_or_create')) {
    /**
     * Get random instance for the given model class or create new.
     *
     * @param string $model
     * @param int $count
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection
     */
    function random_or_create($model, $count = null, $attributes = [])
    {
        $instance = new $model;

        if (!$instance->count()) {
            return $model::factory($count)->create($attributes);
        }

        if (count($attributes)) {
            foreach ($attributes as $key => $value) {
                $instance = $instance->where($key, $value);
            }
        }

        return $instance->get()->random();
    }

    /**
     * Get random instance for the given model class or create new.
     *
     * @param $size
     * @param string $unit
     * @return string
     */
    function humanFileSize($size, string $unit = ""): string
    {
        if ((!$unit && $size >= 1 << 30) || $unit === "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit === "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit === "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }
}

if (!function_exists('app_name')) {
    /**
     * Get the application name.
     *
     * @return string
     */
    function app_name()
    {
        // if (!file_exists(storage_path('installed'))) {
        //     return config('app.name', 'Laravel');
        // }

        return Settings::locale(app()->getLocale())
            ->get('name', config('app.name', 'Laravel'))
            ?: config('app.name', 'Laravel');
    }
}

if (!function_exists('app_logo')) {
    /**
     * Get the application logo url.
     *
     * @return string
     */
    function app_logo()
    {
        // if (!file_exists(storage_path('installed'))) {
        //     return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
        // }

        if (($model = Settings::instance('logo')) && $file = $model->getFirstMediaUrl('logo')) {
            return $file;
        }

        return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
    }
}

if (!function_exists('app_favicon')) {
    /**
     * Get the application favicon url.
     *
     * @return string
     */
    function app_favicon()
    {
        // if (!file_exists(storage_path('installed'))) {
        //     return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
        // }
        if (($model = Settings::instance('favicon')) && $file = $model->getFirstMediaUrl('favicon')) {
            return $file;
        }

        return '/favicon.ico';
    }
}

if (!function_exists('app_login_logo')) {
    /**
     * Get the application login logo url.
     *
     * @return string
     */
    function app_login_logo()
    {
        // if (!file_exists(storage_path('installed'))) {
        //     return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
        // }
        if (($model = Settings::instance('loginLogo')) && $file = $model->getFirstMediaUrl('loginLogo')) {
            return $file;
        }

        return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
    }
}

if (!function_exists('app_login_background')) {
    /**
     * Get the application login background url.
     *
     * @return string
     */
    function app_login_background()
    {
        // if (!file_exists(storage_path('installed'))) {
        //     return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
        // }
        if (($model = Settings::instance('loginBackground')) && $file = $model->getFirstMediaUrl('loginBackground')) {
            return $file;
        }

        return 'https://ui-avatars.com/api/?name=' . rawurldecode(config('app.name')) . '&bold=true';
    }
}

if (!function_exists('isActive')) {
    /**
     * Set the active class to the current opened menu.
     *
     * @param string|array $route
     * @param string $className
     * @return string
     */
    function isActive($route, $className = 'active')
    {
        if (is_array($route)) {
            return in_array(Route::currentRouteName(), $route) ? $className : '';
        }
        if (Route::currentRouteName() == $route) {
            return $className;
        }
        if (strpos(URL::current(), $route)) {
            return $className;
        }
    }
}

if (!function_exists('getSubdirectory')) {
    /**
     * Set the active class to the current opened menu.
     *
     * @param bool $keep_trailing_slash
     * @param bool $keep_front_slash
     * @return string
     */
    function getSubdirectory($keep_trailing_slash = false, $keep_front_slash = false)
    {
        $subdirectory = '';

        $app_url = config('app.url');

        // Check host to ignore default values.
        $app_host = parse_url($app_url, PHP_URL_HOST);

        if ($app_url && !in_array($app_host, ['localhost', 'example.com'])) {
            $subdirectory = parse_url($app_url, PHP_URL_PATH);
        } else {
            // Before app is installed
            $subdirectory = $_SERVER['PHP_SELF'];

            $filename = basename($_SERVER['SCRIPT_FILENAME']);

            if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
                $subdirectory = $_SERVER['SCRIPT_NAME'];
            } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
                $subdirectory = $_SERVER['PHP_SELF'];
            } elseif (array_key_exists('ORIG_SCRIPT_NAME', $_SERVER) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
                $subdirectory = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
            } else {
                // Backtrack up the script_filename to find the portion matching
                // php_self
                $path = $_SERVER['PHP_SELF'];
                $file = $_SERVER['SCRIPT_FILENAME'];
                $segs = explode('/', trim($file, '/'));
                $segs = array_reverse($segs);
                $index = 0;
                $last = \count($segs);
                $subdirectory = '';
                do {
                    $seg = $segs[$index];
                    $subdirectory = '/' . $seg . $subdirectory;
                    ++$index;
                } while ($last > $index && (false !== $pos = strpos($path, $subdirectory)) && 0 != $pos);
            }
        }

        if ($subdirectory === null) {
            $subdirectory = '';
        }

        $subdirectory = str_replace('public/index.php', '', $subdirectory);
        $subdirectory = str_replace('index.php', '', $subdirectory);

        $subdirectory = trim($subdirectory, '/');
        if ($keep_trailing_slash) {
            $subdirectory .= '/';
        }

        if ($keep_front_slash && $subdirectory != '/') {
            $subdirectory = '/' . $subdirectory;
        }

        return $subdirectory;
    }
}

if (!function_exists('layout')) {
    /**
     * Retrieve the view layout name.
     *
     * @param string $type
     * @return string
     */
    function layout($type)
    {
        $field = $type == 'dashboard' ? 'dashboard_template' : 'template';

        if ($type = 'dashboard') {
            if ($value = Config::get('layouts.dashboard')) {
                return "dashboard::.{$value}.";
            }
        }

        return 'dashboard::';
    }
}


// calculate the time difference between two timestamps
function time_difference($start)
{
    $end = time();
    $uts['start'] = strtotime($start);
    $uts['end'] = strtotime($end);
    if ($uts['start'] !== false && $uts['end'] !== false) {
        if ($uts['end'] >= $uts['start']) {
            $diff = $uts['end'] - $uts['start'];
            if ($days = intval((floor($diff / 86400)))) {
                $diff = $diff % 86400;
            }
            if ($hours = intval((floor($diff / 3600)))) {
                $diff = $diff % 3600;
            }
            if ($minutes = intval((floor($diff / 60)))) {
                $diff = $diff % 60;
            }
            $diff = intval($diff);
            return array('days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $diff);
        }
    }
    return false;
}


function calc($lat1, $lon1, $lat2, $lon2, $unit = 'K')
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}


function fcm_notification($token, $content, $title, $message = '')
{
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    $user = User::where('device_token', $token)->first();

    if ($user->type_id == 1) {
        $android_channel_id = "MuriCar";
        $sound = 'user.wav';
    } else {
        $android_channel_id = "MuriCarDriver";
        $sound = 'bellsnotify.wav';
    }

    $notification = [
        'notification' => $message,
        'sender' => auth()->user()->id,
        'receiver' => $user->id,
        'sound' => $sound,
        'vibrate' => 1,
        'title' => $title,
        'body' => $content,
        'priority' => 'high',
        "android_channel_id" => $android_channel_id,
        "aps" => [
            "title" => $title,
            "body" => $content,
            "sound" => $sound,
            "badge" => 3
        ]
    ];

    $extraNotificationData = ["data" => $notification];

    $fcmNotification = [
        'to' => $token, //single token
        'notification' => $notification,
        'sound' => request()->server->get('SERVER_NAME') . '/public/bellsnotify.wav',
        'data' => $extraNotificationData
    ];
    $headers = [
        'Authorization: key=' . env('FCM_SERVER_KEY'),
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);
    return true;
}


function delFile($model)
{
    $arr = $model->pluck('id')->toArray();
    foreach ($arr as $id) {
        $media = Media::find($id);
        $media->delete();
    }
}


function activate($model, $status)
{
    $model->update(['is_active' => $status]);
    return $model;
}


function isExist($model, $id)
{
    try {
        return $model::where('id', $id)->exists();
    } catch (\Throwable $th) {
        return '#';
    }
}


// Chat (pusher)
require __DIR__ . '/pusher/vendor/autoload.php';

function sendPusher($channel, $event, $data)
{
    $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER', 'eu'), // cluster
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        env('PUSHER_APP_KEY', 'f445bd65df4cb4d5475c'), // app key
        env('PUSHER_APP_SECRET', 'cead8baf643a259220d0'), // app secret
        env('PUSHER_APP_ID', '1626236'), // app id
        $options
    );

    return $pusher->trigger($channel, $event, $data);
}



if (!function_exists('user')) {
    function user()
    {
        try {
            $paylod = explode('|', request()->header('Authorization'), 2);
            $token = count($paylod) == 2 ? $paylod[1] : null;
            return PersonalAccessToken::findToken($token)?->tokenable()->first();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('canGetNotifications')) {
    function canGetNotifications($user, $model = null): bool
    {
        $userOrderNotification = (bool) is_null($user->order_notification) ? true : $user->order_notification;
        $isOrderClass = is_null($model) ? false : $model == Order::class;

        if ($isOrderClass) {
            return $userOrderNotification;
        }

        return true;
    }
}




if (!function_exists('translations')) {
    function translations($model, $attribute)
    {
        if ($model == Settings::class) {
            return [
                'en' => Settings::locale('en')->get($attribute),
                'ar' => Settings::locale('ar')->get($attribute),
            ];
        }

        return [
            'en' => $model->translate('en')?->$attribute,
            'ar' => $model->translate('ar')?->$attribute,
        ];
    }
}




if (!function_exists('languages')) {
    function languages()
    {
        return json_decode(json_encode(config('locales')['languages']));
    }
}


if (!function_exists('get_service_validation_rules')) {
    function get_service_validation_rules($class)
    {
        preg_match('/(?<=Modules\\\\)\w+/', get_class($class), $matches);
        $wordAfterModules = $matches[0];
        if ($service = request('service', request('service_id'))) {
            $service = is_object($service) ? $service->id : $service;
            $serviceName = ServicesEnum::serviceName($service);
            $class = 'Modules\\' . $wordAfterModules . '\Http\Requests\\' . ucfirst($serviceName) . 'Request';
            if (class_exists($class)) {
                return app($class)->rules();
            }
        }
        return [];
    }
}

if (!function_exists('getPaginates')) {
    function getPaginates($collection, $name = "data")
    {
        return [
            $name => $collection,
            'per_page' => $collection->perPage(),
            'path' => $collection->path(),
            'total' => $collection->total(),
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'previous_page_url' => $collection->previousPageUrl(),
            'last_page' => $collection->lastPage(),
            'has_more_pages' => $collection->hasMorePages(),
        ];
    }
}


if (!function_exists('generateAttributeMatrix')) {

    function generateAttributeMatrix($attributes): array
    {
        $result = [[]];

        foreach ($attributes as $attribute) {
            $temp = [];
            foreach ($result as $combination) {
                foreach ($attribute->options as $option) {
                    $temp[] = array_merge(
                        $combination,
                        [$option->id]
                    );
                }
            }
            $result = $temp;
        }

        ksort($result);

        foreach ($result as $key => $value) {
            asort($value);
            $final[] = implode('-', $value);
        }

        $final = collect($final)->unique()->toArray();

        return $final;
    }

    if (!function_exists('deliveryPrice')) {
        function deliveryPrice($lat, $lng)
        {


            $price = deliveryPriceUnit($lat, $lng);

            if ($price) {
                return $price;
            }

            $message = __('areas::areas.outside_area');
            throw new HttpResponseException(ApiTrait::sendErrorDataWithCode(["error" => [$message]], $message));
        }
    }

    if (!function_exists('deliveryPriceUnit')) {
        function deliveryPriceUnit($lat, $lng)
        {
            // Usage in Laravel
            $location = ['lat' => $lat, 'lng' => $lng];

            foreach (Area::all() as $area) {
                $polygon = $area->waypoints;
                if (pointInPolygon($location, $polygon)) {
                    return $area->price; // You are inside this area
                }
            }

            return 0;
        }
    }


    if (!function_exists('getAddressArea')) {
        function getAddressArea($lat, $lng)
        {
            // Usage in Laravel
            $location = ['lat' => $lat, 'lng' => $lng];

            foreach (Area::all() as $area) {
                $polygon = $area->waypoints;
                if (pointInPolygon($location, $polygon)) {
                    return $area; // You are inside this area
                }
            }

            return 0;
        }
    }
}



if (!function_exists('pointInPolygon')) {
    function pointInPolygon($point, $polygon)
    {
        $x = $point['lng'];
        $y = $point['lat'];
        $inside = false;
        $n = count($polygon);

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i]['lng'];
            $yi = $polygon[$i]['lat'];
            $xj = $polygon[$j]['lng'];
            $yj = $polygon[$j]['lat'];

            $intersect = (($yi > $y) != ($yj > $y)) &&
                ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);

            if ($intersect)
                $inside = !$inside;
        }

        return $inside;
    }
}
