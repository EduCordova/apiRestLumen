<?php
 namespace App;

 use Illuminate\Database\Eloquent\Model;

 class Author extends Model
 {
   protected $fillable = [
    'name','email', 'github', 'twitter','location', 'latest_article_published'
   ];
//above ->> encima , anterior, de arriba;

   protected $hidden = [];
 }