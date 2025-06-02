<?php

abstract class View
{
    protected $smarty;
    protected $template;
    protected $args;

    public function __construct()
    {
        $this->smarty = new Smarty\Smarty();
        $this->smarty->setTemplateDir(PROJECT_ROOT . SLASH . 'templates');
        $this->smarty->setCompileDir(PROJECT_ROOT . SLASH . 'templates_c');
        $this->smarty->setCacheDir(PROJECT_ROOT . SLASH . 'cache');
        $this->smarty->setConfigDir(PROJECT_ROOT . SLASH . 'configs');
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function assign($key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    abstract public function render($args);
}
