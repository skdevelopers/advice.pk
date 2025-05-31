<div x-data="propertySearch('{{ $type }}')" class="p-6 bg-white md:rounded-xl rounded-none shadow-md">
    <form @submit.prevent="searchProperties">
        <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
            <!-- Search, Category, Min Price, Max Price Inputs -->
            <!-- Use Hously’s classes as per earlier suggestion -->
            <!-- ... -->
            <div class="lg:mt-6">
                <button type="submit"
                        class="btn bg-green-600 hover:bg-green-700 border-green-600 text-white w-full !h-12 rounded"
                        :disabled="loading">
                    <span x-show="!loading">Search</span>
                    <span x-show="loading">Searching...</span>
                </button>
            </div>
        </div>
    </form>
    <template x-if="searched">
        <div class="mt-4">
            <template x-if="loading">
                <div class="text-center text-slate-400 py-6">Loading...</div>
            </template>
            <template x-if="!loading && results.length === 0">
                <div class="text-center text-slate-400 py-6">No properties found.</div>
            </template>
            <template x-if="!loading && results.length">
                <!-- Render property results as per Hously card grid -->
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-[30px] mt-8">
                    <template x-for="property in results" :key="property.id">
                        <!-- Card markup here, reuse card component/Blade partial if possible -->
                    </template>
                </div>
            </template>
        </div>
    </template>
</div>
