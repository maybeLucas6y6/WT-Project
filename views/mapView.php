<?php


class MapView extends View
{
    private $googleMapsApiKey = 'AIzaSyDQz3eIc4qVe1iNkZaehSEz94GhJRxkPP0';

    public function render($args)
    {
        try {
            $this->smarty->assign("googleMapsApiKey", $this->googleMapsApiKey);
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
