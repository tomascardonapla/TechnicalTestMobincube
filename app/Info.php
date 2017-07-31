<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'info';

    public function contact ()
    {
        return $this->belongsTo('App\Contact', 'idContact');
    }
}

?>