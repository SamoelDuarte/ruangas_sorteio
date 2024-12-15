<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Sorteio;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Listar todos os clientes.
     */
    public function index()
    {
        $clientes = Cliente::with('sorteio')->orderBy('id', 'desc')->get();


        // Buscar todos os sorteios disponíveis
        $sorteios = Sorteio::all();

        // Retornar a view com os dados
        return view('cliente.index', compact('clientes', 'sorteios'));
    }

    /**
     * Criar um novo cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'telefone' => 'required',
            'sorteio_id' => 'required|exists:sorteios,id',  // Validando que o sorteio existe
        ]);

        // Criando o cliente com o sorteio associado
        Cliente::create([
            'telefone' => $request->telefone,
            'sorteio_id' => $request->sorteio_id,
        ]);

        return redirect()->route('cliente.index');
    }

    /**
     * Exibir um cliente específico.
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        return response()->json($cliente);
    }

    /**
     * Atualizar um cliente.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        $validated = $request->validate([
            'telefone' => 'sometimes|required|string|max:20',
            'link' => 'nullable|string|url',
            'numero_da_sorte' => 'sometimes|required|integer',
        ]);

        $cliente->update($validated);

        return response()->json([
            'message' => 'Cliente atualizado com sucesso!',
            'cliente' => $cliente,
        ]);
    }

    /**
     * Deletar um cliente.
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        $cliente->delete();
        return redirect()->route('cliente.index')->with('success', 'Cliente deletado com sucesso!');
    }
}
