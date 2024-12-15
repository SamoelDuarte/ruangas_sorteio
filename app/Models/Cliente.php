<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Cliente extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'telefone',
        'link',
        'sorteio_id',
        'numero_da_sorte',
    ];


    public function setTelefoneAttribute($value)
    {
        // Limpar o telefone, removendo qualquer caractere que não seja número
        $telefoneLimpo = preg_replace('/\D/', '', $value);
    
        // Codificar o telefone com Base64
        $this->attributes['telefone'] = base64_encode($telefoneLimpo);
    
        // Criar o link com o telefone codificado
        $this->attributes['link'] = env('APP_URL')."/sorteio/". $this->attributes['telefone'];
    }
    
    public function getTelefoneAttribute($value)
    {
        // Decodificar o telefone codificado antes de retorná-lo
        return base64_decode($value);
    }
   
    public function sorteio()
{
    return $this->belongsTo(Sorteio::class);
}

}
