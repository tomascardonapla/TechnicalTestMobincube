<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contact';

    public function info ()
    {
        return $this->hasOne('App\Info', 'idContact');
    }

    public function map ()
    {
        return $this->hasOne('App\Map', 'idContact');
    }

    public function getTypeAttribute ()
    {
        return 'contact';
    }

}

?>