{{-- resources/views/front/partials/property-search-form.blade.php --}}
<form action="#" class="registration-form text-slate-900 text-start">
    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
        <div>
            <label class="form-label font-medium text-slate-900 dark:text-white">
                Search : <span class="text-red-600">*</span>
            </label>
            <div class="filter-search-form relative filter-border mt-2">
                <i class="uil uil-search icons"></i>
                <input name="keyword" type="text" class="form-input filter-input-box !bg-gray-50 dark:!bg-slate-800 border-0"
                       placeholder="Search your keywords" x-model="search.keyword">
            </div>
        </div>
        <div>
            <label class="form-label font-medium text-slate-900 dark:text-white">Select Categories:</label>
            <div class="filter-search-form relative filter-border mt-2">
                <i class="uil uil-estate icons"></i>
                <select class="form-select z-2" name="category" x-model="search.category">
                    <option value="">All Categories</option>
                    <option value="Houses">Houses</option>
                    <option value="Apartment">Apartment</option>
                    <option value="Offices">Offices</option>
                    <option value="Townhome">Townhome</option>
                </select>
            </div>
        </div>
        <div>
            <label class="form-label font-medium text-slate-900 dark:text-white">Min Price :</label>
            <div class="filter-search-form relative filter-border mt-2">
                <i class="uil uil-usd-circle icons"></i>
                <select class="form-select" name="min_price" x-model="search.min_price">
                    <option value="">Min Price</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                    <option value="3000">3000</option>
                    <option value="4000">4000</option>
                    <option value="5000">5000</option>
                    <option value="6000">6000</option>
                </select>
            </div>
        </div>
        <div>
            <label class="form-label font-medium text-slate-900 dark:text-white">Max Price :</label>
            <div class="filter-search-form relative mt-2">
                <i class="uil uil-usd-circle icons"></i>
                <select class="form-select" name="max_price" x-model="search.max_price">
                    <option value="">Max Price</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                    <option value="3000">3000</option>
                    <option value="4000">4000</option>
                    <option value="5000">5000</option>
                    <option value="6000">6000</option>
                </select>
            </div>
        </div>
        <div class="lg:mt-6">
            <input type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded"
                   value="Search" @click.prevent="searchProperties">
        </div>
    </div>
</form>
