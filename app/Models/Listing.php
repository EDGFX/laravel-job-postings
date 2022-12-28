<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'company', 'location', 'website', 'email', 'description', 'tags', 'logo'];

    public function scopeFilter($query, array $filters) {
        //Null Coelse: If tag is not false then move on, if it is then do nothing.
        if($filters['tag'] ?? false) {
            //English Translation: SQL Query Where Tags Are Tag (% meaning any values before or after)
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if($filters['search'] ?? false) {
            //Use SQL Query to return values/fields that match what was typed in the search bar.
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    //Listing Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
