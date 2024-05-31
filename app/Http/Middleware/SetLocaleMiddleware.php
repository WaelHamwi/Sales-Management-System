<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        // Get the locale from the session
     // Default to Arabic if not set

        if(isset($request->lang)){ //check the request in the url
          // Validate the locale
          if (!in_array($request->lang, ['en', 'ar'])) {//if contains en or ar
              abort(400); 
          }
          // Store the selected language in the session
          Session::put('language', $request->lang);//storing the language in the session's language parameter from the request

        }
        $language = Session::get('language');
        if($language != null){
          App()->setLocale($language);
        }

        return $next($request);
    }
}
