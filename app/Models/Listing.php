<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags', 'logo', 'user_id'];

    public function scopeFilter($query, array $filters) {
      if($filters['tag'] ?? false) {
        $query->where('tags', 'like', '%' . request('tag') . '%');
      }

      if ($filters['search'] ?? false) {
        $query->where('title', 'like', '%' . request('search') . '%')
          ->orWhere('description', 'like', '%' . request('search') . '%')
          ->orWhere('tags', 'like', '%' . request('search') . '%');
      }
    }

    // Relationship To User. 
    
    //The user function in the provided Listing model defines an Eloquent relationship between the Listing model and the User model. Specifically, it establishes a "Belongs To" relationship, indicating that each instance of a Listing belongs to a single User.

    // This function allows you to access the User that a particular Listing is associated with directly from an instance of the Listing model. For example, if you have a listing and you want to access the user who created it, you can do so by calling $listing->user, where $listing is an instance of the Listing model.

    // belongsTo(User::class, 'user_id') tells Laravel that the Listing model is linked to the User model by the foreign key user_id in the listings table. This means that the listings table has a user_id column which references the id column of the users table, establishing the relationship.
    public function user() {
      return $this->belongsTo(User::class, 'user_id');
    }
}
