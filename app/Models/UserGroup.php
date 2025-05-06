<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    // Define the relationship with users
    public function users()
    {
        return $this->hasMany(User::class, 'user_level', 'group_level'); // 'user_level' is the foreign key in the users table, 'group_level' is the local key in the user_groups table
    }
}
