{{-- resources/views/front/partials/featured-properties.blade.php --}}
<section
    class="container mx-auto px-4 sm:px-6 lg:px-8 mt-16"
    x-data="featuredProperties()"
    x-init="fetch()"
>
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties.
        </p>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div class="animate-pulse bg-slate-200 dark:bg-slate-700 rounded-2xl h-96"></div>
        <div class="animate-pulse bg-slate-200 dark:bg-slate-700 rounded-2xl h-96"></div>
        <div class="animate-pulse bg-slate-200 dark:bg-slate-700 rounded-2xl h-96"></div>
        <div class="animate-pulse bg-slate-200 dark:bg-slate-700 rounded-2xl h-96"></div>
    </div>

    <!-- Properties Grid -->
    <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch">
        <template x-for="property in properties" :key="property.id">
            <div x-html="window.renderPropertyCard(property)"></div>
        </template>
    </div>

    <!-- Empty State -->
    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">
        <p class="text-slate-500 dark:text-slate-400">No properties found.</p>
    </div>

    <!-- View More Button -->
    <div class="text-center mt-8" x-show="properties.length > 0">
        <a href="/properties" class="btn text-green-600 hover:text-green-700 rounded-full">
            View More Properties &rarr;
        </a>
    </div>
</section>
