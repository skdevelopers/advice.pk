{{-- resources/views/front/partials/featured-properties.blade.php --}}
<section class="container mx-auto mt-16" x-data="featuredProperties()" x-init="fetch()">
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties without any agent or commissions.
        </p>
    </div>

    {{--
        • On large screens: 3 columns
        • On medium screens: 2 columns
        • On small/mobile: 1 column
        • gap-[30px] matches Hously’s gutter spacing
    --}}
    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-[30px]">
        <template x-for="property in properties" :key="property.id">
            <div
                    class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 transition ease-in-out duration-500"
            >
                {{-- IMAGE WRAPPER --}}
                <div class="relative h-56 w-full overflow-hidden">
                    {{--
                        • Use the largest responsive URL at index 0 for lg screens, or
                          fall back to the last element if the array is empty.
                        • In this example we simply pick the largest (index 0).
                    --}}
                    <img
                            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                            x-bind:src="property.property_image_responsive.length
                            ? property.property_image_responsive[0]
                            : '{{ asset('assets/admin/images/error.png') }}'"
                            alt="Featured Property Image"
                            x-on:error="$event.target.src='{{ asset('assets/admin/images/error.png') }}'"
                    >

                    {{-- “Sale” badge (only if property.purpose == 'sale', adjust logic as needed) --}}
                    <template x-if="property.purpose === 'sale'">
                        <div class="absolute top-4 right-4 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            Sale
                        </div>
                    </template>

                    {{-- If you have other badges (e.g. “Rent”), you can add more <template x-if="…"> blocks here --}}
                </div>

                {{-- DETAILS SECTION --}}
                <div class="p-6 flex flex-col justify-between h-full">
                    {{-- Title + Price --}}
                    <div class="mb-4">
                        <a
                                :href="'/properties/' + property.slug"
                                class="block text-lg font-semibold text-slate-900 dark:text-white hover:text-green-600 transition duration-300"
                                x-text="property.title"
                        ></a>
                        <div class="mt-1 flex items-center">
                            {{-- Price in green --}}
                            <span class="text-green-600 font-bold text-xl mr-2">
                                $<span x-text="new Intl.NumberFormat().format(property.price)"></span>
                            </span>
                            {{-- Location (if you store location) --}}
                            <span class="text-slate-400 text-sm" x-text="property.location ?? 'n/a'"></span>
                        </div>
                    </div>

                    {{-- Icons Row: Area / Beds / Baths (or whatever your “features” are) --}}
                    <div class="mb-4 flex flex-wrap items-center text-slate-500 text-sm space-x-4">
                        {{-- Area --}}
                        <div class="flex items-center">
                            <i data-feather="arrows-expand" class="w-5 h-5 text-green-600 mr-1"></i>
                            <span x-text="property.area || '–'"></span>
                        </div>
                        {{-- Beds --}}
                        <div class="flex items-center">
                            <i data-feather="home" class="w-5 h-5 text-green-600 mr-1"></i>
                            <span x-text="property.beds || 0"></span>
                        </div>
                        {{-- Baths --}}
                        <div class="flex items-center">
                            <i data-feather="droplet" class="w-5 h-5 text-green-600 mr-1"></i>
                            <span x-text="property.baths || 0"></span>
                        </div>
                    </div>

                    {{-- Star Rating + View Count --}}
                    <div class="mb-4 flex items-center justify-between text-slate-500 text-sm">
                        {{-- ★★★★★ Stars (hardcoded or dynamic) --}}
                        <div class="flex items-center space-x-1">
                            <template x-for="star in Array(Math.floor(property.rating || 0)).fill()">
                                <i data-feather="star" class="w-4 h-4 text-yellow-400"></i>
                            </template>
                            <span x-text="property.rating ? '(' + property.rating + ')' : '(0)'"></span>
                        </div>
                        {{-- View count --}}
                        <div class="flex items-center">
                            <i data-feather="eye" class="w-4 h-4 text-slate-400 mr-1"></i>
                            <span x-text="property.views || 0"></span>
                        </div>
                    </div>

                    {{-- CALL / WHATSAPP Buttons --}}
                    <div class="mt-auto flex gap-3">
                        <a
                                :href="'tel:' + property.phone"
                                class="flex-1 py-2 text-center border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 transition duration-300"
                        >
                            CALL
                        </a>
                        <a
                                :href="'https://wa.me/' + property.whatsapp_number"
                                target="_blank"
                                class="flex-1 py-2 text-center bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300"
                        >
                            WHATSAPP
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>
    {{-- “No properties found” / “Loading…” messages --}}
    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">No properties found.</div>
    <div class="text-center pt-10" x-show="loading">Loading...</div>

    {{-- “View More Properties” link, centered below the grid --}}
    <div class="text-center mt-8">
        <a
                href="/properties"
                class="inline-block text-green-600 hover:text-green-700 font-medium transition duration-300"
        >
            View More Properties &rarr;
        </a>
    </div>


</section>
