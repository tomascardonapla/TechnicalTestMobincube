<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'screens';

    public function app ()
    {
        return $this->hasBelong('App\App', 'idApp');
    }


}

?>