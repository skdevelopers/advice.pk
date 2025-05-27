<form @submit.prevent="searchProperties('{{ $type }}')" class="space-y-4">
    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6">
        <div>
            <label class="font-medium text-slate-900">Search <span class="text-red-600">*</span></label>
            <input name="keyword" type="text" class="form-input bg-gray-50 dark:bg-slate-800 border-0" placeholder="Search keywords" x-model="search.keyword">
        </div>
        <div>
            <label class="font-medium text-slate-900">Select Categories:</label>
            <select class="form-select" x-model="search.category">
                <option value="">All</option>
                <option value="Houses">Houses</option>
                <option value="Apartment">Apartment</option>
                <option value="Offices">Offices</option>
                <option value="Townhome">Townhome</option>
            </select>
        </div>
        <div>
            <label class="font-medium text-slate-900">Min Price :</label>
            <select class="form-select" x-model="search.min_price">
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
        <div>
            <label class="font-medium text-slate-900">Max Price :</label>
            <select class="form-select" x-model="search.max_price">
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
        <div class="lg:mt-6">
            <button type="submit" class="btn bg-green-600 text-white w-full h-12 rounded">Search</button>
        </div>
    </div>
</form>
