<?php

class AuthView extends View
{
    public function render($args)
    {
        try {
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // TODO delete this
    public function renderError($message)
    {
        $this->smarty->assign('error', $message);
        $this->smarty->display('error.tpl');
    }
}
