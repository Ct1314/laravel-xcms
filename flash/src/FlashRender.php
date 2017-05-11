<?php
namespace Flash;

use Illuminate\Session\Store;


class FlashRender
{
    /**
     * @var Object Store
     */
    protected $session;

    /**
     * @var array options
     */
    protected $options;

    /**
     * @var string scriptOptions
     */
    protected $scriptOptions;


    /**
     * FlashRender constructor.
     * @param Store $session
     */
    public function __construct(Store $session)
    {

        $this->session = $session;
        
        $this->options = config('flashmessage');
    
    }

    /**
     * @name getMessage
     * @desc get flash session message
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return mixed
     */
    public function getMessage()
    {
        return $this->session->get('laravel_flash_message')?:false;
    }

    /**
     * @name getLevel
     * @desc get flash session message level
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return mixed
     */
    public function getLevel()
    {
        return $this->session->get('laravel_flash_level')?:false;
    }

    public function getDescription()
    {
        return $this->session->get('laravel_flash_description')?:false;
    }


    /**
     * @name closeButton
     * @desc initial closeButton option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function closeButton()
    {
        $this->scriptOptions = '{closeButton:'.$this->options['closeButton'].',';
    }

    /**
     * @name debug
     * @desc initial debug mode option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function debug()
    {
        $this->scriptOptions .= 'debug:'.$this->options['closeButton'].',';

    }

    /**
     * @name positionClass
     * @desc initial positionClass style option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function positionClass()
    {
        $this->scriptOptions .= 'positionClass:"'.$this->options['positionClass'].'",';
    }

    /**
     * @name showDuration
     * @desc initial showDuration animate option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function showDuration()
    {
        $this->scriptOptions .= 'showDuration:'.$this->options['showDuration'].',';
    }

    /**
     * @name hideDuration
     * @desc initial hideDuration animate option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function hideDuration()
    {
        $this->scriptOptions .= 'hideDuration:'.$this->options['hideDuration'].',';
    }

    /**
     * @name timeOut
     * @desc initial message show time option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function timeOut()
    {
        $this->scriptOptions .= 'timeOut:'.$this->options['timeOut'].',';
    }

    /**
     * @name showEasing
     * @desc initial message show showEasing animate option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function showEasing()
    {
        $this->scriptOptions .= 'showEasing:"'.$this->options['showEasing'].'",';
    }

    /**
     * @name hideEasing
     * @desc initial message show hideEasing animate option
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function hideEasing()
    {
        $this->scriptOptions .= 'hideEasing:"'.$this->options['hideEasing'].'",';
    }

    /**
     * @name showMethod
     * @desc initial message show showMethod option method with jquery
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function showMethod()
    {
        $this->scriptOptions .= 'showMethod:"'.$this->options['showMethod'].'",';
    }

    /**
     * @name hideMethod
     * @desc initial message show hideMethod option method with jquery
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function hideMethod()
    {
        $this->scriptOptions .= 'hideMethod:"'.$this->options['hideMethod'].'"';
    }

    /**
     * @name  scriptOptions
     * @desc  initial  message script options
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return string
     */
    public function scriptOptions()
    {
        $this->closeButton();
        $this->debug();
        $this->positionClass();
        $this->showDuration();
        $this->hideDuration();
        $this->timeOut();
        $this->showEasing();
        $this->hideEasing();
        $this->showMethod();
        $this->hideMethod();
        $this->scriptOptions.='}';
        return $this->scriptOptions;
    }

    /**
     * @name script
     * @desc generate script code
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return string
     */
    public function script()
    {
        if(!$this->getMessage()) return "";
        
        $level = $this->getLevel();
        
        $message = $this->getMessage();

        $description = $this->getDescription();
        
        $options = $this->scriptOptions();

        return "toastr." . $level . "(".
            "'".$message."',".
            "'".$description."',".
            $options.");";
    }

    /**
     * @name render
     * @desc render script to view
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return string
     */
    public function render()
    {
        return "<script>".$this->script()."</script>";
    }
}