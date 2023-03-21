<?php

namespace SYSOTEL\OTA\Common\Helpers\Session;

class SessionFlashManager
{
    /**
     * @param string $message
     * @param string $title
     */
    public static function flashSuccessMessage(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_MEDIUM, SessionFlash::TYPE_SUCCESS);
    }


    /**
     * @param string $message
     * @param string $title
     */
    public static function flashSuccessAlert(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_HIGH, SessionFlash::TYPE_SUCCESS);
    }

    /**
     * @param string $message
     * @param string $title
     */
    public static function flashWarningMessage(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_MEDIUM, SessionFlash::TYPE_WARNING);
    }

    /**
     * @param string $message
     * @param string $title
     */
    public static function flashWarningAlert(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_HIGH, SessionFlash::TYPE_WARNING);
    }

    /**
     * @param string $message
     * @param string $title
     */
    public static function flashErrorMessage(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_MEDIUM, SessionFlash::TYPE_ERROR);
    }

    /**
     * @param string $message
     * @param string $title
     */
    public static function flashErrorAlert(string $message, string $title = '')
    {
        self::flash($message, $title, SessionFlash::PRIORITY_HIGH, SessionFlash::TYPE_ERROR);
    }

    /**
     * @param string $message
     * @param $title
     * @param $priority
     * @param $type
     */
    public static function flash(string $message, $title, $priority, $type)
    {
        (new SessionFlash())
            ->setMessage($message)
            ->setTitle($title)
            ->setPriority($priority)
            ->setType($type)
            ->createFlash();
    }
}
