<?php
/**
 * Created by PhpStorm.
 * User: AK-52
 * Date: 2018-10-20
 * Time: 14:56
 */
namespace App\Http\Middleware;

use Closure;

class Activity
{
    /**
     * 前置
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    /*public function handle($request, Closure  $next)
    {
        if(time() < strtotime('2018-10-21')){
            return redirect('activity0');
        }
        return $next($request);
    }*/

    /**
     * 后置操作
     * @param $request
     * @param Closure $next
     */
    public function handle($request, Closure  $next)
    {

        $response =  $next($request);
        echo ($response);
        //逻辑
        echo '我是后置操作';
    }
}