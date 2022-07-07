<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Roteiro extends Model
{
    use HasFactory;

    protected $table = 'roteiros';

    protected $fillable = [
        'name', 'headline', 'status', 'venda', 'locacao', 'saida', 'duracao',
        //Seo
        'content',
        'notasadicionais',
        'slug',
        'metatags',
        'mapadogoogle',
        'views',
        'legendaimgcapa',
        'exibirmarcadagua',
        //Valores Venda
        'libera_venda',
        'exibivalores_venda',
        'valor_venda',
        'valor_v_zerocinco',
        'valor_v_seisdoze',
        'valor_venda_promocional',
        //Valores Locação
        'libera_locacao', 'exibivalores_locacao', 'valor_locacao', 'valor_locacao_promocional',
        //Datas
        'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo',
        //Endereço
        'cep', 'rua', 'num', 'complemento', 'bairro', 'cidade', 'uf'        
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
        return $this->hasMany(RoteiroGb::class, 'roteiro_id', 'id')->orderBy('cover', 'ASC');
    }
    
    public function countimages()
    {
        return $this->hasMany(RoteiroGb::class, 'roteiro_id', 'id')->count();
    }

    public function imagesmarcadagua()
    {
        return $this->hasMany(RoteiroGb::class, 'roteiro_id', 'id')->whereNull('marcadagua')->count();
    }

    /**
     * Accerssors and Mutators
     */
    public function getContentWebAttribute()
    {
        return Str::words($this->content, '20', ' ...');
    }
    
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

        //return Storage::url(Cropper::thumb($cover['path'], 960, 860));
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

    public function getPublishAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setSlug()
    {
        if(!empty($this->name)){
            $roteiro = Roteiro::where('name', $this->name)->first(); 
            if(!empty($roteiro) && $roteiro->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->name) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->name);
            }            
            $this->save();
        }
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
    
}
