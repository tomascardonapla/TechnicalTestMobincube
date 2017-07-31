<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apps';

    public function screens()
    {
        return $this->hasMany('App\Screen', 'idApp');
    }
}

?>