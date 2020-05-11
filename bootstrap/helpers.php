<?php
function test_helper() {
    return 'OK';
}
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
//众筹.没用
function ngrok_url($routeName, $parameters = [])
{
    // 开发环境，并且配置了 NGROK_URL
    if(app()->environment('local') && $url = config('app.ngrok_url')) {
        // route() 函数第三个参数代表是否绝对路径
        return $url.route($routeName, $parameters, false);
    }

    return route($routeName, $parameters);
}

//分期金额精度
// 默认的精度为小数点后两位
function big_number($number, $scale = 2)
{
    return new \Moontoast\Math\BigNumber($number, $scale);
}
