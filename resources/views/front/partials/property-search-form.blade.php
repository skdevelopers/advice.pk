{{-- resources/views/front/partials/property-search-form.blade.php --}}
<div
        x-data="propertySearch('{{ $type }}')"
        x-init="loadOptions()"
        class="w-full"
>
    <form class="registration-form text-slate-900 text-start" @submit.prevent="searchProperties">
        <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
            <!-- Search Input -->
            <div>
                <label class="form-label font-medium text-slate-900 dark:text-white">
                    Search : <span class="text-red-600">*</span>
                </label>
                <div class="filter-search-form relative filter-border mt-2">
                    <i class="uil uil-search icons"></i>
                    <input
                            name="keyword"
                            type="text"
                            class="form-input filter-input-box !bg-gray-50 dark:!bg-slate-800 border-0"
                            placeholder="Search your keywords"
                            x-model="search.keyword"
                    >
                </div>
            </div>

            <!-- Category Dropdown -->
            <div>
                <label class="form-label font-medium text-slate-900 dark:text-white">
                    Select Categories:
                </label>
                <div class="filter-search-form relative filter-border mt-2">
                    <i class="uil uil-estate icons"></i>
                    <select
                            class="form-select z-2"
                            x-ref="category"
                            name="category"
                            x-model="search.category"
                    >
                        <template x-for="option in options.categories" :key="option.value">
                            <option :value="option.value" x-text="option.label"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Min Price Dropdown -->
            <div>
                <label class="form-label font-medium text-slate-900 dark:text-white">
                    Min Price :
                </label>
                <div class="filter-search-form relative filter-border mt-2">
                    <i class="uil uil-usd-circle icons"></i>
                    <select
                            class="form-select"
                            x-ref="minPrice"
                            name="min_price"
                            x-model="search.min_price"
                    >
                        <template x-for="option in options.min_prices" :key="option.value">
                            <option :value="option.value" x-text="option.label"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Max Price Dropdown -->
            <div>
                <label class="form-label font-medium text-slate-900 dark:text-white">
                    Max Price :
                </label>
                <div class="filter-search-form relative mt-2">
                    <i class="uil uil-usd-circle icons"></i>
                    <select
                            class="form-select"
                            x-ref="maxPrice"
                            name="max_price"
                            x-model="search.max_price"
                    >
                        <template x-for="option in options.max_prices" :key="option.value">
                            <option :value="option.value" x-text="option.label"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Search Button -->
            <div class="lg:mt-6">
                <button type="submit"
                        class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded">
                    Search
                </button>
            </div>
        </div>
    </form>
</div>
