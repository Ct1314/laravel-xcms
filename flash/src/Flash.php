<?php

namespace Flash;


class Flash
{
    /**
     * @var Object FlashSession
     */
    protected $session;

    /**
     * @var Object FlashRender
     */
    protected $render;

    /**
     * @name __construct
     * @desc  initial session render object
     * @param FlashSession $session
     * @param FlashRender $flashRender
     * @author Yuanchang.xu
     * @since 2017-03-14
     */
    public function __construct(LaravelSession $session,FlashRender $flashRender)
    {
        $this->session = $session;
        $this->render = $flashRender;
    }

    /**
     * @name success
     * @desc flash success message
     * @param String $message
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function success($message,$description = null)
    {
        $this->message($message,'success',$description);
    }

    /**
     * @name info
     * @desc flash into message
     * @param String $message
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function info($message,$description = null)
    {
        $this->message($message,'info',$description);
    }

    /**
     * @name warning
     * @desc flash warning message
     * @param String $message
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function warning($message,$description = null)
    {
        $this->message($message,'warning',$description);
    }

    /**
     * @name error
     * @desc flash error message
     * @param String $message
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function error($message,$description = null)
    {
        $this->message($message,'error',$description);
    }

    /**
     * @name error
     * @desc flash message
     * @param String $message
     * @param String $level
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function message($message,$level,$description = null)
    {
        $this->session->flash('laravel_flash_message',$message);
        $this->session->flash('laravel_flash_description',$description);
        $this->session->flash('laravel_flash_level',$level);
    }

    /**
     * @name render
     * @desc render scripts
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return mixed
     */
    public function render()
    {
        return $this->render->render();
    }
}