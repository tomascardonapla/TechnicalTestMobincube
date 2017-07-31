<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail';

    public function getTypeAttribute () {
        return 'detail';
    }
}

?>