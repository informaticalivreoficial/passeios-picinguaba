<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

class EmbarcacaoGb extends Model
{
    use HasFactory;

    protected $table = 'embarcacao_gbs'; 
    
    protected $fillable = [
        'embarcacao_id',
        'path',
        'cover',
        'marcadagua'
    ];
    
    /**
     * Accerssors and Mutators
     */

    public function getUrlCroppedAttribute()
    {
        //return Storage::url(Cropper::thumb($this->path, 1366, 768));
        return Storage::url($this->path);
    }

    public function getUrlImageAttribute()
    {
        return Storage::url($this->path);
    }

    public function setMacadaguaAttribute($value)
    {
        $this->attributes['marcadagua'] = ($value == true || $value == '1' ? 1 : 0);
    }
}
