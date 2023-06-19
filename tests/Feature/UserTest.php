<?php

use App\Models\Despesa;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('usuário pode se logar', function () {

    $user = User::factory()->create();

    $response = $this->postJson('/v1/login', [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'test'
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['token']);
});

test('usuário não pode fazer login com credenciais inválidas', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/v1/login', [
        'email' => $user->email,
        'password' => 'senha_incorreta',
        'device_name' => 'test'
    ]);

    $response->assertStatus(401);
    $response->assertJsonStructure(['message']);
    $response->assertJson(['message' => 'email or password wrong']);
});

test('usuário pode se deslogar', function () {

    Sanctum::actingAs(User::factory()->create());

    $response = $this->getJson('/v1/logout');

    $response->assertStatus(200);
    $response->assertJsonStructure(['data']);
    expect($response->json('data'))->toBe("User Logout successfully.");

});

test('usuário não autenticado não pode acessar rota protegida', function () {
    $response = $this->getJson('/v1/user');

    $response->assertStatus(401);
    $response->assertJsonStructure(['message']);
    $response->assertJson(['message' => 'Unauthenticated.']);
});

test('usuário logado obtém informações corretas ao acessar a rota /v1/user', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->getJson('/v1/user');

    $response->assertStatus(200);
    $response->assertJson([
        'id' => Auth::user()->id,
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'type' => Auth::user()->type,
        'created_at' => Auth::user()->created_at->toISOString(),
        'updated_at' => Auth::user()->updated_at->toISOString(),
    ]);
    $response->assertJsonStructure([
        'id',
        'name',
        'email',
        'type',
        'created_at',
        'updated_at',
        '_links' => [
            [
                'href',
                'rel',
                'type',
            ],
            [
                'href',
                'rel',
                'type',
            ],
            [
                'href',
                'rel',
                'type',
            ],
        ],
    ]);
});

test('apenas moderadores e administradores podem excluir uma despesa', function () {
    // Criar um usuário com papel de administrador
    $admin = User::factory()->isAdmin()->create();

    // Criar um usuário com papel de moderador
    $moderator = User::factory()->isMod()->create();

    // Criar um usuário sem papel de moderador ou administrador
    $regularUser = User::factory()->isRegular()->create();

    // Criar uma despesa associada ao usuário regular
    $despesaRegularUser = Despesa::factory()->create(['dono' => $regularUser->id]);

    // Padrão do JSON de resposta esperado quando a exclusão é bem-sucedida
    $retornoEsperadoDespesaDeletada = [
        'deleted' => 'Usuário removido com sucesso.',
        '_links' => [
            [
                'href' => 'http://localhost/v1/despesas',
                'rel' => 'despesas.index',
                'type' => 'GET|HEAD'
            ],
            [
                'href' => 'http://localhost/v1/despesas',
                'rel' => 'despesas.store',
                'type' => 'POST'
            ],
            [
                'href' => 'http://localhost/v1/despesas/ID',
                'rel' => 'despesas.destroy',
                'type' => 'DELETE'
            ]
        ]
    ];

    // Autenticar como o usuário administrador
    Sanctum::actingAs($admin);

    // Tentar excluir a despesa associada ao usuário regular como o usuário administrador
    $response = $this->deleteJson('/v1/despesas/' . $despesaRegularUser->id);

    // Verificar que a resposta tem status 200 (OK)
    $response->assertStatus(200);
    $response->assertJson($retornoEsperadoDespesaDeletada);

    // Criar uma despesa associada ao usuário regular
    $despesaRegularUser = Despesa::factory()->create(['dono' => $regularUser->id]);

    // Autenticar como o usuário moderador
    Sanctum::actingAs($moderator);

    // Tentar excluir a despesa associada ao usuário regular como o usuário moderador
    $response = $this->deleteJson('/v1/despesas/' . $despesaRegularUser->id);

    // Verificar que a resposta tem status 200 (OK)
    $response->assertStatus(200);
    $response->assertJson($retornoEsperadoDespesaDeletada);

    // Criar uma despesa associada ao usuário regular
    $despesaRegularUser = Despesa::factory()->create(['dono' => $regularUser->id]);

    // Autenticar como o usuário regular
    Sanctum::actingAs($regularUser);

    // Tentar excluir a despesa associada ao usuário regular como o usuário regular
    $response = $this->deleteJson('/v1/despesas/' . $despesaRegularUser->id);

    // Verificar que a resposta tem status 403 (Forbidden)
    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Apenas Moderadores podem excluir despesas'
    ]);
});
