<section
        class="container mx-auto px-4 sm:px-6 lg:px-8 mt-16"
        x-data="featuredProperties()"
        x-init="fetch()"
>
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties without any agent or commissions.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px] items-stretch">
        <template x-for="property in properties" :key="property.id">
            <div x-html="window.renderPropertyCard(property)"></div>
        </template>
    </div>

    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">
        No properties found.
    </div>
    <div class="text-center pt-10" x-show="loading">
        Loading...
    </div>

    <div class="text-center mt-8">
        <a href="/properties" class="btn text-green-600 hover:text-green-700 !rounded-full">
            View More Properties &rarr;
        </a>
    </div>
</section>
