<?php

namespace App\Http\Controllers;

use App\Http\Requests\DespesaStoreRequest;
use App\Http\Requests\DespesaUpdateRequest;
use App\Http\Resources\DespesaResource;
use App\Http\Resources\DespesasCollection;
use App\Models\Despesa;
use App\Notifications\DespesaCriada;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    /**
     * Cria uma nova instância do controlador e aplica a autorização para os recursos de Despesa.
     */
    public function __construct()
    {
        $this->authorizeResource(Despesa::class, 'despesa');
    }

    /**
     * Retorna uma coleção de despesas.
     *
     * Se o usuário autenticado for um administrador ou moderador, retorna todas as despesas paginadas.
     * Caso contrário, retorna apenas as despesas do usuário autenticado paginadas.
     *
     */
    public function index()
    {
        if (Auth::user()->isAdministrator() || Auth::user()->isMod()) {
            return (new DespesasCollection(Despesa::paginate()))->response();
        }

        if(Auth::user()->isRegular())
            return (new DespesasCollection(Auth::user()->despesas()->paginate()))->response();
    }

    /**
     * Armazena uma nova despesa.
     *
     * Valida os dados da requisição usando o DespesaStoreRequest.
     * Cria uma nova despesa com os dados validados.
     * Retorna a resposta com a despesa criada no formato DespesaResource.
     *
     */
    public function store(DespesaStoreRequest $request)
    {
        $validated = $request->validated();

        $despesa = Despesa::create($validated);

        Auth::user()->notify(new DespesaCriada($despesa));

        return (new DespesaResource($despesa))->response();
    }

    /**
     * Retorna os detalhes de uma despesa específica.
     */
    public function show(Despesa $despesa)
    {
        return (new DespesaResource($despesa))->response();
    }

    /**
     * Atualiza uma despesa existente.
     *
     * Valida os dados da requisição usando o DespesaUpdateRequest.
     * Atualiza a despesa com os dados validados.
     * Retorna a resposta com a despesa atualizada no formato DespesaResource.
     *
     */
    public function update(DespesaUpdateRequest $request, Despesa $despesa)
    {
        $validated = $request->validated();

        $despesa->update($validated);

        return (new DespesaResource($despesa))->response();
    }

    /**
     * Remove uma despesa existente.
     *
     * Remove a despesa do banco de dados.
     * Retorna uma resposta em formato JSON indicando se a despesa foi removida com sucesso,
     * juntamente com os links para a rota de listagem (despesas.index) e criação (despesas.store) de despesas.
     *
     */
    public function destroy(Despesa $despesa)
    {
        $deleted = $despesa->delete();

        return new JsonResponse([
            'deleted' => $deleted ? "Despesa removida com sucesso." : "Falha ao remover despesa.",
            '_links' => [
                [
                    'href' => route('despesas.index'),
                    'rel' => "despesas.index",
                    'type' => "GET|HEAD"
                ],
                [
                    'href' => route('despesas.store'),
                    'rel' => "despesas.store",
                    'type' => "POST"
                ],
                [
                    'href' => route('despesas.destroy', "ID"),
                    'rel' => "despesas.destroy",
                    'type' => "DELETE"
                ]
            ]
        ]);
    }
}
