<?php

class DocumentationView extends View
{
    public function render($args)
    {
        $this->template = 'documentation';
        try {
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
