<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Cropper;

class Embarcacao extends Model
{
    use HasFactory;

    protected $table = 'embarcacoes';

    protected $fillable = [
        'name', 'headline', 'status',
        //Seo
        'content',
        'passageiros',
        'tripulantes',
        'comprimento',
        'ano_de_construcao',
        'slug',
        'metatags',
        'views',
        'legendaimgcapa',
        'exibirmarcadagua'        
    ];

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    public function images()
    {
        return $this->hasMany(EmbarcacaoGb::class, 'embarcacao_id', 'id')->orderBy('cover', 'ASC');
    }
    
    public function countimages()
    {
        return $this->hasMany(EmbarcacaoGb::class, 'embarcacao_id', 'id')->count();
    }

    public function imagesmarcadagua()
    {
        return $this->hasMany(EmbarcacaoGb::class, 'embarcacao_id', 'id')->whereNull('marcadagua')->count();
    }

    /**
     * Accerssors and Mutators
     */
    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !Storage::disk()->exists(env('AWS_PASTA') . $cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        //return Storage::url(Cropper::thumb($cover['path'], 740, 648));
        return Storage::url($cover['path']);
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !Storage::disk()->exists(env('AWS_PASTA') . $cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }

    public function setExibirmarcadaguaAttribute($value)
    {
        $this->attributes['exibirmarcadagua'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setSlug()
    {
        if(!empty($this->name)){
            $embarcacao = Embarcacao::where('name', $this->name)->first(); 
            if(!empty($embarcacao) && $embarcacao->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->name) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->name);
            }            
            $this->save();
        }
    }
}
