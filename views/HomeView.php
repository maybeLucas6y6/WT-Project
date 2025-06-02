<?php

class HomeView extends View
{
    public function render($args)
    {
        $this->template = 'home';
        try {
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
