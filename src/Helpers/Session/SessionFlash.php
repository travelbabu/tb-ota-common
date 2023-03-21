<?php

namespace SYSOTEL\OTA\Common\Helpers\Session;

class SessionFlash
{
    public $type = null;
    public $priority = null;
    public $title = null;
    public $message = null;

    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    public function __construct() {}

    /**
     * @param string $type
     * @return SessionFlash
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $priority
     * @return SessionFlash
     */
    public function setPriority(string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string $title
     * @return SessionFlash
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $message
     * @return SessionFlash
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return void
     */
    public function createFlash(): void
    {
        session()->flash('flash', $this);
    }
}