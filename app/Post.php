<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded=[];

    public function tags(){
        return $this->belongsToMany('App\Tag');// thiết lập mối quan hệ với model tag(table : tags)
}
public function user(){
    return $this->belongsTo('App\User');
}
public function category(){
    return $this->belongsTo('App\Category');
}

     // Get all of the post's comments.
     //da hinh one to many
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function getTagsIdArray(){
        $id_array=[];

        if(count($this->tags)){

         foreach ($this->tags as $tag) { // call function tags
          $id_array[]=$tag->id;
         }

        }
        return $id_array;
  }
}
