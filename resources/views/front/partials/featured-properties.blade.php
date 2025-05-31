<div x-data="featuredProperties()" x-init="fetch()" class="container relative lg:mt-24 mt-16">
    <div class="grid grid-cols-1 pb-8 text-center">
        <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">A great platform to buy, sell and rent your properties without any agent or commissions.</p>
    </div>
    <div>
        <template x-if="loading">
            <div class="text-center text-slate-400 py-8">Loading featured properties...</div>
        </template>
        <template x-if="!loading && properties.length === 0">
            <div class="text-center text-slate-400 py-8">No properties found.</div>
        </template>
        <template x-if="!loading && properties.length">
            <div class="grid lg:grid-cols-2 grid-cols-1 gap-[30px] mt-8">
                <template x-for="property in properties" :key="property.id">
                    <!-- Advice card markup here -->
                </template>
            </div>
        </template>
    </div>
</div>
