<?php

class AssetView extends View{
    private $asset;


    public function initAsset($asset){
        $this->asset = $asset;
    }

    public function render($args) {
        try {
            $this->smarty->assign("address", $this->asset['address']);
            $this->smarty->assign("description", $this->asset['description']);
            $this->smarty->assign("price", $this->asset['price']);
            $this->smarty->assign("id", $this->asset['id']);
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    //Trebuie schimbat cu smarty
}
