<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;

    protected $table = 'topiks';
    protected $fillable = ['topik'];

    public function datasets()
    {
        return $this->hasMany(Dataset::class, 'id_topik');
    }
}