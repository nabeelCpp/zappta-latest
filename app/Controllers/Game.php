<?php

namespace App\Controllers;

use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\CompainModel;

class Game extends BaseController
{
    public function index()
    {
        return view('game/index');
    }
}
