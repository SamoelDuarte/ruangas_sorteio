<?php

namespace App\Http\Controllers;

use App\Models\Sorteio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sorteios = Sorteio::with('clientes')->orderBy('id', 'desc')->get();


        // Estruturar os dados para exibir no dashboard
        $dados = $sorteios->map(function ($sorteio) {
            $totalClientes = $sorteio->clientes->count();
            $totalParticipantes = $sorteio->clientes->whereNotNull('numero_da_sorte')->count();

            return [
                'nome' => $sorteio->nome,
                'sorteio_id' => $sorteio->id,
                'numero_sorteio' => $sorteio->numero_sorteio,
                'data_inicio' => $sorteio->getDataInicioFormatadaAttribute(),
                'data_termino' => $sorteio->getDataTerminoFormatadaAttribute(),
                'total_clientes' => $totalClientes,
                'total_participantes' => $totalParticipantes,
            ];
        });

        // Retornar para a view com os dados
        return view('dashboard', compact('dados'));
    }
}
