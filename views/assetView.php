<?php

class AssetView extends View
{
    private $asset;


    public function initAsset($asset)
    {
        $this->asset = $asset;
    }

    public function render($args)
    {
        try {
            $this->smarty->assign("address", $this->asset['address']);
            $this->smarty->assign("description", $this->asset['description']);
            $this->smarty->assign("price", $this->asset['price']);
            $this->smarty->assign("id", $this->asset['id']);
            $this->smarty->assign("is_admin", $args['is_admin']);
            $this->smarty->assign("phone", $args['phone']);
            $this->smarty->assign("email", $args['email']);
            $this->smarty->assign("is_owner", );
            $this->smarty->display($this->template . '.tpl');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    //Trebuie schimbat cu smarty
}
