<?php

use App\Models\User;
use App\Models\Society;
use App\Models\SubSector;
use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, postJson, putJson, deleteJson};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    $this->user      = User::factory()->create();
    $this->society   = Society::factory()->create();
    $this->subsector = SubSector::factory()->create(['society_id'=>$this->society->id]);
    actingAs($this->user);
});

it('can create a property with media', function () {
    $payload = [
        'user_id'       => $this->user->id,
        'society_id'    => $this->society->id,
        'subsector_id'  => $this->subsector->id,
        'title'         => 'My Plot',
        'slug'          => 'my-plot',
        'purpose'       => 'sale',
        'property_type' => 'plots',
        'plot_size'     => '5 Marla',
        'price'         => 1000000,
        'status'        => 'enabled',
        'main_image'    => UploadedFile::fake()->image('house.jpg'),
        'gallery'       => [
            UploadedFile::fake()->image('g1.jpg'),
            UploadedFile::fake()->image('g2.png'),
        ],
    ];

    postJson(route('admin.properties.store'), $payload)
        ->assertRedirect(route('admin.properties.index'))
        ->assertSessionHas('success');

    $prop = Property::where('slug','my-plot')->firstOrFail();
    expect($prop->getFirstMediaUrl('main_image'))->toContain('house.jpg');
    expect($prop->getMedia('gallery'))->toHaveCount(2);
});

it('can update a property', function () {
    $prop = Property::factory()->create([
        'user_id'=>$this->user->id,
        'society_id'=>$this->society->id,
        'subsector_id'=>$this->subsector->id,
        'slug'=>'old-slug',
    ]);
    putJson(route('admin.properties.update',$prop), [
        'user_id'       => $this->user->id,
        'society_id'    => $this->society->id,
        'subsector_id'  => $this->subsector->id,
        'title'         => 'Updated',
        'slug'          => 'updated-slug',
        'purpose'       => 'rent',
        'property_type' => 'homes',
        'status'        => 'disabled',
    ])->assertRedirect(route('admin.properties.index'));

    $this->assertDatabaseHas('properties',['id'=>$prop->id,'slug'=>'updated-slug','status'=>'disabled']);
});

it('can delete a property', function () {
    $prop = Property::factory()->create();
    deleteJson(route('admin.properties.remove',$prop))->assertRedirect(route('admin.properties.index'));
    $this->assertSoftDeleted('properties',['id'=>$prop->id]);
});
