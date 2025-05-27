<?php

use App\Models\User;
use App\Models\Society;
use App\Models\SubSociety;
use function Pest\Laravel\{actingAs, getJson, postJson, putJson, deleteJson};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user    = User::factory()->create();
    $this->society = Society::factory()->create();
    actingAs($this->user);
});

it('can list sub-societies', function () {
    SubSociety::factory()->count(3)->create(['society_id' => $this->society->id]);
    getJson(route('admin.subsocieties.index'))
        ->assertOk()
        ->assertJsonStructure(['data'=>[['id','name','slug','type','society_id']]]);
});

it('can create a sub-society', function () {
    $payload = [
        'society_id'   => $this->society->id,
        'name'         => 'Phase A',
        'slug'         => 'phase-a',
        'type'         => 'Phase',
        'meta_keywords'=> 'phase,a',
        'meta_detail'  => 'details',
        'detail'       => 'Full detail.',
    ];
    postJson(route('admin.subsocieties.store'), $payload)
        ->assertCreated()
        ->assertJson(['success'=>true]);

    $this->assertDatabaseHas('sub_societies', ['slug'=>'phase-a','society_id'=>$this->society->id]);
});

it('can update a sub-society', function () {
    $sub = SubSociety::factory()->create(['society_id'=>$this->society->id,'slug'=>'old']);
    putJson(route('admin.subsocieties.update',$sub), [
        'society_id'=> $this->society->id,
        'name'      =>'New Name',
        'slug'      =>'new-slug',
    ])->assertOk();

    $this->assertDatabaseHas('sub_societies',['id'=>$sub->id,'slug'=>'new-slug','name'=>'New Name']);
});

it('can delete a sub-society', function () {
    $sub = SubSociety::factory()->create(['society_id'=>$this->society->id]);
    deleteJson(route('admin.subsocieties.destroy',$sub))->assertOk();
    $this->assertSoftDeleted('sub_societies',['id'=>$sub->id]);
});
