<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user() === null){
            return redirect()->route('home');
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        if($request->user()->hasAnyRole($roles) || !$roles){
            return $next($request);
        }

        if($request->ajax()){
            return response()->json(['insufficient_permission'=>'']);
        }else{
            $locale = App::getLocale();
            switch ($locale) {
                case 'en':
                    session()->flash('danger', 'Insufficient Permission.');
                    break;
                
                case 'fa':
                    session()->flash('danger', 'دسترسی به این بخش مجاز نیست.');
                    break;
                
                case 'pa':
                    session()->flash('danger', 'تاسی نشی کولی دی زای ته لاس رسی ولری.');
                    break;
                
                default:
                    break;
            }
            return redirect()->back();
        }
    }
}
