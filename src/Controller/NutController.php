<?php

namespace App\Controller;

use App\Controller\AbstractAPIController;
use App\Model\NutManager;

class NutController extends AbstractAPIController
{
    public function index(): string
    {
        $nutManager = new NutManager();
        $nuts = $nutManager->getAllStocks();

        $jsonString = json_encode($nuts);
        return $jsonString;
    }

    public function buy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $nutManager = new NutManager();
            $nutManager->decrementStock($id);

            $updatedStocks = $nutManager->getAllStocks();

            $jsonString = json_encode($updatedStocks);
            return $jsonString;
        }
    }
}
