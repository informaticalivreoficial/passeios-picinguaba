<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passeio extends Model
{
    use HasFactory;

    protected $table = 'passeios';

    protected $fillable = [
        'status', 'venda', 'locacao', 'saida', 'duracao',        
        'roteiro_id',
        'vagas',
        'notasadicionais',        
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

    public function scopeVenda($query)
    {
        return $query->where('venda', 1);
    }

    public function scopeLocacao($query)
    {
        return $query->where('locacao', 1);
    }

    /**
     * Relacionamentos
     */
    public function roteiro()
    {
        return $this->belongsTo(Roteiro::class,'roteiro_id', 'id');
    }

    /**
     * Accerssors and Mutators
     */
    public function getTipoVenda()
    {
        if($this->venda == '1' && $this->locacao == '1'){
            return 'Venda Individual<br>Venda de Pacote';
        }
        if($this->venda == '1' && $this->locacao == null){
            return 'Venda Individual';
        }else{
            return 'Venda de Pacote';
        }
    }

    public function setLiberaVendaAttribute($value)
    {
        $this->attributes['libera_venda'] = ($value == '1' ? 1 : 0);
    }

    public function setLiberaLocacaoAttribute($value)
    {
        $this->attributes['libera_locacao'] = ($value == '1' ? 1 : 0);
    }

    public function setExibirvaloresVendaAttribute($value)
    {
        $this->attributes['exibivalores_venda'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setExibirvaloresLocacaoAttribute($value)
    {
        $this->attributes['exibivalores_locacao'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setExibirmarcadaguaAttribute($value)
    {
        $this->attributes['exibirmarcadagua'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setVendaAttribute($value)
    {
        $this->attributes['venda'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setLocacaoAttribute($value)
    {
        $this->attributes['locacao'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setValorVendaAttribute($value)
    {
        $this->attributes['valor_venda'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorVendaAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorVZerocincoAttribute($value)
    {
        $this->attributes['valor_v_zerocinco'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorVZerocincoAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorVSeisdozeAttribute($value)
    {
        $this->attributes['valor_v_seisdoze'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorVSeisdozeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorVendaPromocionalAttribute($value)
    {
        $this->attributes['valor_venda_promocional'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorVendaPromocionalAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }
    
    public function setValorLocacaoAttribute($value)
    {
        $this->attributes['valor_locacao'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorLocacaoAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }    
    
    public function setValorLocacaoPromocionalAttribute($value)
    {
        $this->attributes['valor_locacao_promocional'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorLocacaoPromocionalAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }


     /**
     * Mutator Segunda-feira
     *
     * @param $value
     */
    public function setSegundaAttribute($value)
    {
        $this->attributes['segunda'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Terça-feira
     *
     * @param $value
     */
    public function setTercaAttribute($value)
    {
        $this->attributes['terca'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Quarta-feira
     *
     * @param $value
     */
    public function setQuartaAttribute($value)
    {
        $this->attributes['quarta'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Quinta-feira
     *
     * @param $value
     */
    public function setQuintaAttribute($value)
    {
        $this->attributes['quinta'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Sexta-feira
     *
     * @param $value
     */
    public function setSextaAttribute($value)
    {
        $this->attributes['sexta'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Sabado
     *
     * @param $value
     */
    public function setSabadoAttribute($value)
    {
        $this->attributes['sabado'] = (($value === true || $value === 'on') ? 1 : 0);
    }
     /**
     * Mutator Domingo
     *
     * @param $value
     */
    public function setDomingoAttribute($value)
    {
        $this->attributes['domingo'] = (($value === true || $value === 'on') ? 1 : 0);
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function clearField(?string $param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
