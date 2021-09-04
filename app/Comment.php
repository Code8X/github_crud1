<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
//get owwning commentable model
public function commentable()
{
    return $this->morphTo();
}
}
