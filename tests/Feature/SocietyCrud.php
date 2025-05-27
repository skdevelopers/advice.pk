<?php

use App\Models\User;
use App\Models\City;
use App\Models\Society;
use App\Services\AiService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, get, post, put, delete};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Fake the storage disk for media uploads
    Storage::fake('public');

    // Create a signed‐in user
    $this->user = User::factory()->create();

    // Create a city for the societies
    $this->city = City::factory()->create(['name' => 'Test City', 'slug'=>'test-city']);

    // Mock the AI SEO service so it returns predictable data
    $this->mock(AiService::class, function ($mock) {
        $mock->shouldReceive('generate')
            ->andReturn([
                'seo_title'       => 'SEO Title',
                'seo_description' => 'SEO Description',
                'seo_keywords'    => 'foo,bar',
            ]);
    });
});

it('can create a society via AJAX and stores all fields', function () {
    actingAs($this->user);

    $payload = [
        'society_name' => 'My Society',
        'slug'         => 'my-society',
        'city_id'      => $this->city->id,
        'user_id'      => $this->user->id,
        'overview'     => 'An overview.',
        'detail'       => 'Some details.',
        'status'       => 'enabled',
        // simulate media uploads
        'main_image'   => UploadedFile::fake()->image('main.jpg'),
        'banner'       => UploadedFile::fake()->image('banner.png'),
        'has_houses'   => 1,
        'houses_title'       => 'Houses Page',
        'houses_keywords'    => 'homes,key',
        'houses_description' => 'Desc',
        'has_sub_sectors' => 'Y',
        'sub_sectors' => [
            ['name'=>'SubA','title'=>'SubA','slug'=>'suba','meta_keywords'=>'k','meta_detail'=>'d','detail'=>'desc','block'=>'Block']
        ],
    ];

    postJson(route('admin.societies.store'), $payload)
        ->assertStatus(201)
        ->assertJson([
            'message' => 'Society created successfully.',
        ]);

    // Assert in database
    $this->assertDatabaseHas('societies', [
        'slug'        => 'my-society',
        'overview'    => 'An overview.',
        'status'      => 'enabled',
        'seo_title'   => 'SEO Title',
    ]);

    // Assert media stored
    $soc = Society::where('slug','my-society')->firstOrFail();
    expect($soc->getFirstMediaUrl('main_image'))->toContain('main.jpg')
        ->and($soc->getFirstMediaUrl('banner'))->toContain('banner.png')
        ->and($soc->subSectors)->toHaveCount(1)
        ->and($soc->subSectors->first()->name)->toBe('SubA');

    // Assert sub‐sector relationship
});

it('can update a society', function () {
    actingAs($this->user);

    $soc = Society::factory()->create([
        'city_id' => $this->city->id,
        'user_id' => $this->user->id,
        'slug'    => 'orig-slug',
    ]);

    putJson(route('admin.societies.update', $soc), [
        'society_name' => 'Renamed',
        'city_id'      => $this->city->id,
        'user_id'      => $this->user->id,
        'status'       => 'disabled',
        // keep slug unique, or pass new slug:
        'slug'         => 'renamed-society',
    ])->assertOk()
        ->assertJson(['message'=>'Society updated successfully.']);

    $this->assertDatabaseHas('societies', [
        'id'     => $soc->id,
        'slug'   => 'renamed-society',
        'status' => 'disabled',
    ]);
});

it('can soft delete and restore a society', function () {
    actingAs($this->user);

    $soc = Society::factory()->create([
        'city_id' => $this->city->id,
        'user_id' => $this->user->id,
    ]);

    deleteJson(route('admin.societies.remove', $soc))->assertOk();
    $this->assertSoftDeleted('societies', ['id'=>$soc->id]);

    postJson(route('admin.societies.restore', $soc->id))->assertOk();
    $this->assertDatabaseHas('societies', ['id'=>$soc->id,'deleted_at'=>null]);
});
