<div x-data="propertyTabs()" class="...">
    <ul class="flex justify-center space-x-4">
        <li>
            <button
                    :class="tab === 'buy' ? 'bg-green-600 text-white' : 'bg-gray-100'"
                    @click="tab = 'buy'"
            >Buy</button>
        </li>
        <li>
            <button
                    :class="tab === 'sell' ? 'bg-green-600 text-white' : 'bg-gray-100'"
                    @click="tab = 'sell'"
            >Sell</button>
        </li>
        <li>
            <button
                    :class="tab === 'rent' ? 'bg-green-600 text-white' : 'bg-gray-100'"
                    @click="tab = 'rent'"
            >Rent</button>
        </li>
    </ul>

    <div class="mt-4">
        <div x-show="tab === 'buy'">
            @include('front.partials.search-form', ['type' => 'buy'])
        </div>
        <div x-show="tab === 'sell'">
            @include('front.partials.search-form', ['type' => 'sell'])
        </div>
        <div x-show="tab === 'rent'">
            @include('front.partials.search-form', ['type' => 'rent'])
        </div>
    </div>
</div>
