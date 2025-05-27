<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Database\Factories\CityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City withoutTrashed()
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Property
 *
 * @property int $id
 * @property int $user_id
 * @property int $society_id
 * @property int|null $sub_sector_id
 * @property string $purpose
 * @property string $property_type
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $plot_no
 * @property string|null $street
 * @property string|null $location
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $plot_size
 * @property string|null $plot_dimensions
 * @property int|null $price
 * @property int|null $rent
 * @property string $rent_type
 * @property array<array-key, mixed>|null $features
 * @property array<array-key, mixed>|null $nearby_facilities
 * @property array<array-key, mixed>|null $installment_plan
 * @property bool $best_selling
 * @property bool $today_deal
 * @property bool $approved
 * @property string $status
 * @property string|null $map_embed
 * @property string|null $video_embed
 * @property string|null $short_video_url
 * @property string|null $extra_data
 * @property string|null $created_by
 * @property int $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Society $society
 * @property-read \App\Models\SubSector|null $subsector
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBestSelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereExtraData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereInstallmentPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMapEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereNearbyFacilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereShortVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSocietyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSubSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTodayDeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereVideoEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withoutTrashed()
 * @mixin \Eloquent
 */
	class Property extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Society
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property string $name
 * @property string $slug
 * @property array<array-key, mixed>|null $meta_data
 * @property array<array-key, mixed>|null $map_data
 * @property string|null $overview
 * @property string|null $detail
 * @property bool $has_residential_plots
 * @property bool $has_commercial_plots
 * @property bool $has_houses
 * @property bool $has_apartments
 * @property bool $has_farm_houses
 * @property bool $has_shop
 * @property array<array-key, mixed>|null $property_types
 * @property int $created_by
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read City $city
 * @property-read User|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, SubSector> $subSectors
 * @property-read int|null $sub_sectors_count
 * @property-read User $user
 * @method static SocietyFactory factory($count = null, $state = [])
 * @method static Builder<static>|Society newModelQuery()
 * @method static Builder<static>|Society newQuery()
 * @method static Builder<static>|Society onlyTrashed()
 * @method static Builder<static>|Society query()
 * @method static Builder<static>|Society whereCityId($value)
 * @method static Builder<static>|Society whereCreatedAt($value)
 * @method static Builder<static>|Society whereCreatedBy($value)
 * @method static Builder<static>|Society whereDeletedAt($value)
 * @method static Builder<static>|Society whereDetail($value)
 * @method static Builder<static>|Society whereHasApartments($value)
 * @method static Builder<static>|Society whereHasCommercialPlots($value)
 * @method static Builder<static>|Society whereHasFarmHouses($value)
 * @method static Builder<static>|Society whereHasHouses($value)
 * @method static Builder<static>|Society whereHasResidentialPlots($value)
 * @method static Builder<static>|Society whereHasShop($value)
 * @method static Builder<static>|Society whereId($value)
 * @method static Builder<static>|Society whereMapData($value)
 * @method static Builder<static>|Society whereMetaData($value)
 * @method static Builder<static>|Society whereName($value)
 * @method static Builder<static>|Society whereOverview($value)
 * @method static Builder<static>|Society wherePropertyTypes($value)
 * @method static Builder<static>|Society whereSlug($value)
 * @method static Builder<static>|Society whereStatus($value)
 * @method static Builder<static>|Society whereUpdatedAt($value)
 * @method static Builder<static>|Society whereUserId($value)
 * @method static Builder<static>|Society withTrashed()
 * @method static Builder<static>|Society withoutTrashed()
 * @mixin Eloquent
 */
	class Society extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * Class SubSector
 *
 * @package App\Models
 * @property int $id
 * @property int $society_id
 * @property int|null $sub_society_id
 * @property string|null $name
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $meta_keywords
 * @property string|null $meta_detail
 * @property string|null $detail
 * @property string|null $block
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Society $society
 * @property-read \App\Models\SubSociety|null $subSociety
 * @method static \Database\Factories\SubSectorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereMetaDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereSocietyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereSubSocietyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSector whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SubSector extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * Class SubSociety
 *
 * @property int $id
 * @property int $society_id
 * @property string $name
 * @property string $slug
 * @property string|null $type
 * @property string|null $meta_keywords
 * @property string|null $meta_detail
 * @property string|null $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Society $society
 * @property-read Collection<int, \App\Models\SubSector> $subSectors
 * @property-read int|null $sub_sectors_count
 * @method static \Database\Factories\SubSocietyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereMetaDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereSocietyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubSociety withoutTrashed()
 * @mixin \Eloquent
 */
	class SubSociety extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\City|null $city
 * @method static \Database\Factories\SuperFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super withoutTrashed()
 * @mixin \Eloquent
 */
	class Super extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

