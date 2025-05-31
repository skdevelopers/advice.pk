{{-- resources/views/front/partials/featured-properties.blade.php --}}
<section class="container mx-auto mt-16" x-data="featuredProperties()" x-init="fetch()">
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties without any agent or commissions.
        </p>
    </div>
    <div class="grid lg:grid-cols-2 grid-cols-1 gap-[30px] mt-8">
        <template x-for="property in properties" :key="property.id">
            @include('front.partials.property-card')
        </template>
    </div>
    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">No properties found.</div>
    <div class="text-center pt-10" x-show="loading">Loading...</div>
</section>
