<?php

namespace App\Http\Controllers;

use App\Http\Requests\DespesaStoreRequest;
use App\Http\Requests\DespesaUpdateRequest;
use App\Http\Requests\UpdateDespesasRequest;
use App\Http\Resources\DespesaResource;
use App\Http\Resources\DespesasCollection;
use App\Models\Despesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Despesa::class, 'despesa');
    }

    public function index()
    {
        if(Auth::user()->isAdministrator() || Auth::user()->isMod()){
            return (new DespesasCollection(Despesa::paginate()))->response();
        }

        return (new DespesasCollection(Auth::user()->despesas()->paginate()))->response();
    }

    public function store(DespesaStoreRequest $request)
    {
        $validated = $request->validated();

        $despesa = Despesa::create($validated);

        return (new DespesaResource($despesa))->response();
    }

    public function show(Despesa $despesa)
    {
        return (new DespesaResource($despesa))->response();
    }

    public function update(DespesaUpdateRequest $request, Despesa $despesa)
    {
        $validated = $request->validated();

        $despesa->update($validated);

        return (new DespesaResource($despesa))->response();
    }

    public function destroy(Despesa $despesa)
    {
        $deleted = $despesa->delete();

        return new JsonResponse([
            'deleted' => $deleted,
            '_links' => [
                [
                    'href' => route('despesas.index'),
                    'rel' => "despesas.index",
                    'type' => "GET|HEAD"
                ], [
                    'href' => route('despesas.store'),
                    'rel' => "despesas.store",
                    'type' => "POST"
                ]
            ]
        ]);
    }
}
