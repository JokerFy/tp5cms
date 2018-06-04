<?php
namespace app\api\controller\v1;
use app\api\service\AppToken;

/**
 * 获取令牌，相当于登录
 */
class Token
{
    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        $app = new AppToken();
        $result = $app->get($ac, $se);
        session('adminUser',$result);
        return show(1,'登录成功');
    }


}