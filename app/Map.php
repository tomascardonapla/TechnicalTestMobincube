<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'map';

    public function contact ()
    {
        return $this->belongsTo('App\Contact', 'idContact');
    }
}

?>