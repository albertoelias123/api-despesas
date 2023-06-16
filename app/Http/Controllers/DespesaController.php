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
    public function index()
    {
        if(Auth::user()->isAdministrator() || Auth::user()->isMod()){
            $this->authorize('viewAny', Despesa::class);
            $despesas = Despesa::paginate();
            return (new DespesasCollection($despesas))->response();
        }

        $despesas = Auth::user()->despesas();

        $this->authorize('view', $despesas->first());

        return (new DespesasCollection($despesas->paginate()))->response();
    }

    public function store(DespesaStoreRequest $request)
    {
        $this->authorize(Despesa::class, 'create');

        $validated = $request->validated();

        $despesa = Despesa::create($validated);

        return (new DespesaResource($despesa))->response();
    }

    public function show(Despesa $despesa)
    {
        $this->authorize('view', $despesa);

        return (new DespesaResource($despesa))->response();
    }

    public function update(DespesaUpdateRequest $request, Despesa $despesa)
    {
        $this->authorize(Despesa::class, 'update', $despesa);

        $validated = $request->validated();

        $despesa->update($validated);

        return (new DespesaResource($despesa))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Despesa $despesa)
    {
        $this->authorize(Despesa::class, 'delete', $despesa);

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
