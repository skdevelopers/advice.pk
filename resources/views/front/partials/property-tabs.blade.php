{{-- resources/views/front/partials/property-tabs.blade.php --}}
<section class="relative md:pb-24 pb-16">
    <div class="container relative z-1">
        <div class="grid grid-cols-1 justify-center">
            <div class="relative md:-mt-52 -mt-40">
                <div class="grid grid-cols-1">
                    <ul class="inline-block mx-auto sm:w-fit w-full flex-wrap justify-center text-center p-4 bg-white dark:bg-slate-900 backdrop-blur-sm rounded-t-xl border-b border-gray-200 dark:border-gray-800 mt-10"
                        id="myTab" data-tabs-toggle="#StarterContent" role="tablist">
                        <li role="presentation" class="inline-block">
                            <button class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full hover:text-green-600 transition-all duration-500 ease-in-out"
                                    id="buy-home-tab" data-tabs-target="#buy-home" type="button" role="tab" aria-controls="buy-home" aria-selected="true">
                                Buy
                            </button>
                        </li>
                        <li role="presentation" class="inline-block">
                            <button class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full transition-all duration-500 ease-in-out"
                                    id="sell-home-tab" data-tabs-target="#sell-home" type="button" role="tab" aria-controls="sell-home" aria-selected="false">
                                Sell
                            </button>
                        </li>
                        <li role="presentation" class="inline-block">
                            <button class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full transition-all duration-500 ease-in-out"
                                    id="rent-home-tab" data-tabs-target="#rent-home" type="button" role="tab" aria-controls="rent-home" aria-selected="false">
                                Rent
                            </button>
                        </li>
                    </ul>
                    <div id="StarterContent" class="p-6 bg-white dark:bg-slate-900 md:rounded-xl rounded-none shadow-md dark:shadow-gray-700">
                        <div id="buy-home" role="tabpanel" aria-labelledby="buy-home-tab">
                            @include('front.partials.property-search-form', ['type' => 'buy'])
                        </div>
                        <div class="hidden" id="sell-home" role="tabpanel" aria-labelledby="sell-home-tab">
                            @include('front.partials.property-search-form', ['type' => 'sell'])
                        </div>
                        <div class="hidden" id="rent-home" role="tabpanel" aria-labelledby="rent-home-tab">
                            @include('front.partials.property-search-form', ['type' => 'rent'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
