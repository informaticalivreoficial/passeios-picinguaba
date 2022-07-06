<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos'; 

    protected $fillable = [
        'id_gateway',
        'passeio_id',
        'user_id',
        'status',
        'valor',
        'description',
        'total_passageiros',
        'status_gateway',
        'data_compra',
        'token'
    ];

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('status_gateway', 'approved');
    }
    public function scopeInprocess($query)
    {
        return $query->where('status_gateway', 'pending');
    }
    public function scopeRejected($query)
    {
        return $query->where('status_gateway', 'rejected');
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Relacionamentos
     */

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function passeio()
    {
        return $this->belongsTo(Passeio::class, 'passeio_id', 'id');
    }

    /**
     * Accerssors and Mutators
     */
    //Exibe Status MercadoPago
    public function getStatusPayment() {
        if($this->status_gateway == 'approved'){
            return '<span class="right badge badge-success">Aprovado</span>';
        }elseif($this->status_gateway == 'pending'){
            return '<span class="right badge badge-warning">Processando</span>';
        }elseif($this->status_gateway == 'rejected'){
            return '<span class="right badge badge-danger">Cancelado</span>';
        }else{
            return 'Falha'; 
        }
    }    

    public function getCreatedAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return date('d/m/Y', strtotime($value));
    }

    public function setDataCompraAttribute($value)
    {
        $this->attributes['data_compra'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function getDataCompraAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return date('d/m/Y', strtotime($value));
    }

    public function getValorAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
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
