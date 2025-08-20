<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $table = 'datasets';
    protected $fillable = ['id_topik', 'nama_dataset', 'meta_data_json', 'metadata_info', 'files'];

    public function topik()
    {
        return $this->belongsTo(Topik::class, 'id_topik');
    }
}