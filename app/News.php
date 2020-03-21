<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /** JSONに含める属性 */
    protected $visible = [
        'date', 'body',
    ];
}
