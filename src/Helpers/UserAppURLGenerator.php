<?php

namespace SYSOTEL\OTA\Common\Helpers;

class UserAppURLGenerator
{
    /**
     * Get URL for given path
     *
     * @param string $path
     * @param array $params
     * @return string
     */
    public static function URL(string $path, array $params = []): string
    {
        $url = config('settings.user_app_url') . $path;

        if(!empty($params)){
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Get password setup url
     *
     * @param array $params
     * @return string
     */
    public static function passwordSetupURL(array $params = []): string
    {
        return self::URL('setup-password',$params);
    }

    /**
     * Get password setup url
     *
     * @param array $params
     * @return string
     */
    public static function passwordResetURL(array $params = []): string
    {
        return self::URL('reset-password',$params);
    }
}