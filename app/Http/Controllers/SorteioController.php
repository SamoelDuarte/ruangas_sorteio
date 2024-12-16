<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Sorteio;
use Illuminate\Http\Request;

class SorteioController extends Controller
{
    /**
     * Exibe a página de sorteio com os clientes.
     *
     * @return \Illuminate\View\View
     */
    public function cliente($telefone)
    {
        // Buscar o cliente pelo telefone
        $cliente = Cliente::where(['telefone' => $telefone , "numero_da_sorte" => null])->firstOrFail();
        // Verifica se o cliente já tem um número da sorte
        if ($cliente->numero_da_sorte) {
            // Se o cliente já tem um número da sorte, chama a view sorteio.link_usado
            return view('sorteio.link_usado', compact('cliente'));
        }
        $numerosEscolhidos = Cliente::where('sorteio_id', $cliente->sorteio_id)
            ->pluck('numero_da_sorte') // Pega os números da sorte
            ->map(fn($numero) => (string) $numero) // Converte para string, se necessário
            ->values() // Reindexa para remover quaisquer índices
            ->toArray(); // Converte em array simples


        return view('sorteio.cliente', compact('cliente', 'numerosEscolhidos'));
    }

    public function index()
    {
        // Pega todos os sorteios, incluindo os detalhes dos clientes
        $sorteios = Sorteio::all();

        return view('sorteio.index', compact('sorteios'));
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_termino' => 'required|date|after_or_equal:data_inicio',
            'numero_sorteio' => 'required|integer|unique:sorteios,numero_sorteio',
        ]);

        // Criar um novo sorteio
        Sorteio::create([
            'nome' => $request->nome,
            'cliente_id' => $request->cliente_id,
            'data_inicio' => $request->data_inicio,
            'data_termino' => $request->data_termino,
            'numero_sorteio' => $request->numero_sorteio,
        ]);

        return redirect()->route('sorteio.index')->with('success', 'Sorteio criado com sucesso!');
    }

    public function destroy($id)
    {
        $sorteio = Sorteio::findOrFail($id);

        // Verifique se o sorteio tem clientes associados
        if ($sorteio->clientes->isEmpty()) {
            $sorteio->delete();
            return redirect()->route('sorteio.index')->with('success', 'Sorteio deletado com sucesso!');
        }

        return redirect()->route('sorteio.index')->with('error', 'Não é possível deletar, o sorteio possui clientes associados!');
    }

    public function salvarNumeroSorte(Request $request, $id)
    {
        // Validação do número
        $validated = $request->validate([
            'numero_sorte' => 'required|numeric|digits:4',
        ]);

        // Obtenha o sorteio pelo ID
        $cliente = Cliente::findOrFail($id);

        // Salve o número da sorte (ajuste conforme sua lógica de negócio)
        $cliente->numero_da_sorte = $request->numero_sorte;
        $cliente->save();

        return view('sorteio.agradecer_cliente', compact('cliente'));
    }
}
