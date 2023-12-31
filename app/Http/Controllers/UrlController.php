<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Url;
use App\Models\Stat;
use Jenssegers\Agent\Agent;

class UrlController extends Controller
{
        
    CONST BASE_URL = "https://uff.sk/";
    CONST MAX_STRING_LENGTH = 255;

    /**
     * Generates a URL-safe string of 8 characters length, if not specified otherwise
     */
    public function createShortUrl(Request $req) {

        // validate input from request
        $validated = $req->validate([
            'url' => 'required|url:http,https|max:1000'
        ]);

        // TO DO: what if error

        // generate new short URL
        $newUrl = Url::generateUrl();

        $url = new Url;

        $url->long_url = $validated['url'];
        $url->short_url = $newUrl;

        if(Auth::check()) {
            $url->user_id = $req->user()->id;        
        }

        $ok = $url->save();

        return response()->json([
            'shortUrl' => self::BASE_URL . $url->short_url,
            'longUrl' => $url->long_url,
            'userId' => $url->user_id,
            'ok' => $ok,
    	], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * The Redirect
     */
    public function theRedirect(Request $req) {

        // get the corresponding long URL
        $url = Url::where([
            ['short_url', request('shortUrl')],
            ['active', 1]
            ])->first(['id', 'long_url']);
        
        if(isset($url['id']) && isset($url['long_url'])) {

            // gather all the info
            $stat = new Stat;
            $agent = new Agent();

            $stat->browser = $agent->browser();
            $stat->is_mobile = $agent->isMobile();
            $stat->is_tablet = $agent->isTablet();
            $stat->is_desktop = $agent->isDesktop();
            $stat->is_phone = $agent->isPhone();
            $stat->is_robot = $agent->isRobot();
            $stat->device = $agent->device();
            $stat->platform = $agent->platform();

            if($agent->robot()) {
                $stat->robot_name = $agent->robot();
            }

            if($agent->languages()) {
                $stat->languages = implode(',', array_slice($agent->languages(), 0, 3));
            }

            if(isset($_SERVER['REMOTE_ADDR'])) {
                $stat->ip_address = $_SERVER['REMOTE_ADDR'];
            }

            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $stat->http_x_forwarded_for = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, self::MAX_STRING_LENGTH);
            }

            if(isset($_SERVER['HTTP_REFERER'])) {
                $stat->referer = substr($_SERVER['HTTP_REFERER'], 0, self::MAX_STRING_LENGTH);
            }

            if(isset($_SERVER['REQUEST_TIME'])) {
                $stat->request_time = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
            }

            if(isset($_SERVER['QUERY_STRING'])) {
                $stat->query_string = substr($_SERVER['QUERY_STRING'], 0, self::MAX_STRING_LENGTH);
            }
            
            // execution time the closest to the save function as it can be 
            if(isset($_SERVER['REQUEST_TIME_FLOAT'])) {
                $stat->request_duration_in_ms = floor((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000);
            }

            $stat->url_id = $url['id'];

            $stat->save();

            // finally redirect to it
            header('Location: ' . $url['long_url'], true, 301); 
        } else {
            return Redirect::to("/");
        }

        exit();
    }

    /**
     * Retrieve URLs saved by the user. For the dashboard.
     */
    public function getMyUrls(Request $req) {
        
        if(!Auth::check()) {
            return Redirect::route('login');
        }

        $user = $req->user();
        $res = $user->url()->withCount('stat')->get();

        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Toggle active state of URL
     */
    public function toggleActive(Request $req) {

        $ok = false;
        
        if(!Auth::check()) {
            return Redirect::route('login');
        }

        $payload = json_decode($req->getContent(), true);

        $url = Url::find($payload['url_id']);

        if($url->user_id == Auth::id()) {
            $url->active = !$url->active;
            $ok = $url->update();
        }

        return response()->json(['ok' => $ok, 'co' => $payload], 200, [], JSON_UNESCAPED_UNICODE);

    }

    /**
     * Remove URL
     */
    public function removeUrl(Request $req) {

        $ok = false;
        
        if(!Auth::check()) {
            return Redirect::route('login');
        }

        $payload = json_decode($req->getContent(), true);

        $url = Url::find($payload['url_id']);

        if($url->user_id == Auth::id()) {
            $ok = $url->delete();
        }

        return response()->json(['ok' => $ok, 'co' => $payload], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
