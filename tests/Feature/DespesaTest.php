<?php

use App\Models\Despesa;
use App\Models\User;
use App\Notifications\DespesaCriada;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;

test('index retorna uma coleção de despesas', function () {
    $admin = User::factory()->isAdmin()->create();
    $moderator = User::factory()->isMod()->create();
    $user = User::factory()->isRegular()->create();

    $despesas = Despesa::factory(3)->create(['dono' => $user->id]);

    $this->actingAs($admin)
        ->get(route('despesas.index'))
        ->assertOk()
        ->assertJsonCount(3);

    $this->actingAs($moderator)
        ->get(route('despesas.index'))
        ->assertOk()
        ->assertJsonCount(3);

    $this->actingAs($user)
        ->get(route('despesas.index'))
        ->assertOk()
        ->assertJsonCount(3);
});

test('store cria uma nova despesa e retorno dentro do padrão', function () {
    Notification::fake();
    $user = User::factory()->isRegular()->create();
    $dadosDespesa = [
        'descricao' => 'Nova Despesa',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 100.00,
        'dono' => $user->id
    ];

    $response = $this->actingAs($user)
        ->post(route('despesas.store'), $dadosDespesa);

    $response->assertCreated();
    $despesaId = $response->json('id');
    $response->assertJsonFragment([
        'descricao' => $dadosDespesa['descricao'],
        'data' => Carbon::parse($dadosDespesa['data'])->toISOString(),
        'valor' => $dadosDespesa['valor'],
        'dono' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            '_links' => [
                [
                    'href' => 'http://localhost/v1/login',
                    'rel' => 'login',
                    'type' => 'POST',
                ],
                [
                    'href' => 'http://localhost/v1/logout',
                    'rel' => 'logout',
                    'type' => 'GET',
                ],
                [
                    'href' => 'http://localhost/v1/user',
                    'rel' => 'authUser',
                    'type' => 'GET',
                ],
            ],
        ],
        '_links' => [
            [
                'href' => 'http://localhost/v1/despesas',
                'rel' => 'despesas.index',
                'type' => 'GET|HEAD',
            ],
            [
                'href' => 'http://localhost/v1/despesas',
                'rel' => 'despesas.store',
                'type' => 'POST',
            ],
            [
                'href' => 'http://localhost/v1/despesas/' . $despesaId,
                'rel' => 'despesas.show',
                'type' => 'GET|HEAD',
            ],
            [
                'href' => 'http://localhost/v1/despesas/' . $despesaId,
                'rel' => 'despesas.update',
                'type' => 'PUT|PATCH',
            ]
        ],
    ]);

    $despesa = Despesa::find($despesaId);

    $this->assertNotNull($despesa);
    $this->assertEquals($dadosDespesa['descricao'], $despesa->descricao);
    $this->assertEquals($user->id, $despesa->dono()->first()->id);

    Notification::assertSentTo($user, DespesaCriada::class);
});

test('store usa o ID do usuário autenticado como dono quando o campo não está presente na solicitação', function () {
    Notification::fake();
    $user = User::factory()->create();
    $dadosDespesa = [
        'descricao' => 'Nova Despesa',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 100.00
    ];

    $response = $this->actingAs($user)
        ->post(route('despesas.store'), $dadosDespesa);

    $response->assertCreated();
    $response->assertJsonFragment([
        'descricao' => $dadosDespesa['descricao'],
        'data' => Carbon::parse($dadosDespesa['data'])->toISOString(),
        'valor' => $dadosDespesa['valor'],
        'dono' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            '_links' => [
                [
                    'href' => 'http://localhost/v1/login',
                    'rel' => 'login',
                    'type' => 'POST',
                ],
                [
                    'href' => 'http://localhost/v1/logout',
                    'rel' => 'logout',
                    'type' => 'GET',
                ],
                [
                    'href' => 'http://localhost/v1/user',
                    'rel' => 'authUser',
                    'type' => 'GET',
                ],
            ],
        ],
    ]);

    $despesaId = $response->json('id');
    $despesa = Despesa::find($despesaId);

    $this->assertNotNull($despesa);
    $this->assertEquals($dadosDespesa['descricao'], $despesa->descricao);
    $this->assertEquals($user->id, $despesa->dono);

    Notification::assertSentTo($user, DespesaCriada::class);
});

test('store converte o campo "dono" para tipo inteiro quando presente na solicitação', function () {
    Notification::fake();
    $user = User::factory()->create();
    $dadosDespesa = [
        'descricao' => 'Nova Despesa',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 100.00,
        'dono' => (string) $user->id, // Envia o ID do usuário como string
    ];

    $response = $this->actingAs($user)
        ->post(route('despesas.store'), $dadosDespesa);

    $response->assertCreated();
    $response->assertJsonFragment([
        'descricao' => $dadosDespesa['descricao'],
        'data' => Carbon::parse($dadosDespesa['data'])->toISOString(),
        'valor' => $dadosDespesa['valor'],
        'dono' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            '_links' => [
                [
                    'href' => 'http://localhost/v1/login',
                    'rel' => 'login',
                    'type' => 'POST',
                ],
                [
                    'href' => 'http://localhost/v1/logout',
                    'rel' => 'logout',
                    'type' => 'GET',
                ],
                [
                    'href' => 'http://localhost/v1/user',
                    'rel' => 'authUser',
                    'type' => 'GET',
                ],
            ],
        ]
    ]);

    $despesaId = $response->json('id');
    $despesa = Despesa::find($despesaId);

    $this->assertNotNull($despesa);
    $this->assertEquals($dadosDespesa['descricao'], $despesa->descricao);
    $this->assertEquals($user->id, $despesa->dono);

    Notification::assertSentTo($user, DespesaCriada::class);
});

test('store retorna erros de validação quando os campos obrigatórios estão ausentes', function () {
    $user = User::factory()->isAdmin()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(route('despesas.store'), []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['descricao', 'data', 'valor']);
});

test('show retorna os detalhes de uma despesa específica', function () {
    $user = User::factory()->create();
    $despesa = Despesa::factory()->create(['dono' => $user->id]);

    $this->actingAs($user)
        ->get(route('despesas.show', $despesa->id))
        ->assertOk()
        ->assertJsonFragment(['descricao' => $despesa->descricao]);
});

test('show retorna erro quando a despesa não existe', function () {
    $user = User::factory()->create();
    $despesaId = 999; // ID de uma despesa inexistente

    $this->actingAs($user)
        ->get(route('despesas.show', $despesaId))
        ->assertStatus(404)
        ->assertJson(['error' => 'Recurso não encontrado.']);
});


test('update atualiza uma despesa existente', function () {
    $user = User::factory()->create();
    $despesa = Despesa::factory()->create(['dono' => $user->id]);
    $dadosAtualizados = ['descricao' => 'Despesa Atualizada'];

    $this->actingAs($user)
        ->put(route('despesas.update', $despesa->id), $dadosAtualizados)
        ->assertOk()
        ->assertJsonFragment($dadosAtualizados);

    $this->assertDatabaseHas('despesas', $dadosAtualizados);
});

test('destroy remove uma despesa existente', function () {
    $user = User::factory()->isAdmin()->create();
    $despesa = Despesa::factory()->create(['dono' => $user->id]);

    $this->actingAs($user)
        ->delete(route('despesas.destroy', $despesa->id))
        ->assertOk()
        ->assertJsonFragment(['deleted' => 'Despesa removida com sucesso.']);

    $this->assertDatabaseMissing('despesas', ['id' => $despesa->id]);
});

test('usuário com email não verificado recebe erro ao tentar criar despesa', function () {
    $user = User::factory()->unverified()->isRegular()->create();

    Sanctum::actingAs($user);

    $dadosDespesa = [
        'descricao' => 'Nova Despesa',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 100.00,
    ];

    $response = $this->postJson(route('despesas.store'), $dadosDespesa);

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Seu e-mail não foi verificado',
    ]);
});

test('usuário não verificado ou que não seja dono recebe erro ao tentar atualizar despesa', function () {
    $userUnverified = User::factory()->unverified()->isRegular()->create();
    $despesa = Despesa::factory()->create(['dono' => $userUnverified]); // Cria uma despesa com outro dono
    Sanctum::actingAs($userUnverified);
    $dadosAtualizados = [
        'descricao' => 'Descrição atualizada',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 200.00,
    ];
    $response = $this->putJson(route('despesas.update', $despesa->id), $dadosAtualizados);
    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Você não pode atualizar esta despesa',
    ]);

    $userVerified = User::factory()->isRegular()->create();
    Sanctum::actingAs($userVerified);
    $dadosAtualizados = [
        'descricao' => 'Descrição atualizada',
        'data' => Carbon::now()->format('Y-m-d'),
        'valor' => 200.00,
    ];
    $response = $this->putJson(route('despesas.update', $despesa->id), $dadosAtualizados);
    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Você não pode atualizar esta despesa',
    ]);
});
