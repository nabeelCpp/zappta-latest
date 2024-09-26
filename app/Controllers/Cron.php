<?php

namespace App\Controllers;

use App\Models\CompainModel;

class Cron extends BaseController
{
    
    public function index()
    {
        $comp = (new CompainModel())->getCompaign();
        if ( !empty($comp) ) {
            if ( $comp['active'] == 0 ) {
                (new CompainModel())->add([ 'id' => $comp['id'], 'active' => 1, 'status' => 2  ]);
            } else {
                if ( $comp['active'] == 1 && $comp['compain_e_date'] < date('Y-m-d') ) {
                    (new CompainModel())->add([ 'id' => $comp['id'], 'active' => 2, 'status' => 3  ]);
                }
            }
        }
        return true;
    }

    
}
