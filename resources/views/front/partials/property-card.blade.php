<div
        class="group rounded-xl bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl
         dark:shadow-gray-700 dark:hover:shadow-gray-700
         overflow-hidden transition-shadow duration-500 w-full mx-auto"
>
    <div class="md:flex">
        {{-- IMAGE + OVERLAYS --}}
        <div class="relative md:shrink-0 md:w-48 w-full">
            <div class="h-48 w-full overflow-hidden">
                <img
                        x-bind:src="property.property_image_url"
                        alt="Property image"
                        class="h-full w-full object-cover object-center
                 transition-transform duration-500 group-hover:scale-105"
                        x-on:error="$event.target.src = '{{ asset('assets/admin/images/property/placeholder.jpg') }}'"
                >
            </div>

            {{-- Top-right badge (e.g. “Sale” or “Rent”) --}}
            <div class="absolute top-3 right-3">
        <span
                class="bg-green-600 bg-opacity-90 text-white text-xs font-semibold px-2 py-1 rounded-md"
                x-text="property.today_deal ? 'Sale' : (property.purpose === 'rent' ? 'Rent' : '')"
        ></span>
            </div>

            {{-- Bottom-left: view count + photo count --}}
            <div class="absolute bottom-3 left-3 flex space-x-2">
                <div
                        class="flex items-center bg-black bg-opacity-50 rounded-md px-2 py-1 text-white text-xs"
                >
                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                    <span x-text="property.views ?? 0"></span>
                </div>
                <div
                        class="flex items-center bg-black bg-opacity-50 rounded-md px-2 py-1 text-white text-xs"
                >
                    <i data-feather="camera" class="w-4 h-4 mr-1"></i>
                    <span
                            x-text="(property.gallery_urls && property.gallery_urls.length) ? property.gallery_urls.length : 0"
                    ></span>
                </div>
            </div>

            {{-- Bottom-right: Property ID --}}
            <div
                    class="absolute bottom-3 right-3 bg-black bg-opacity-50 text-white text-xs font-medium px-2 py-1 rounded-md"
            >
                P-ID: <span x-text="property.id"></span>
            </div>
        </div>

        {{-- DETAILS SECTION --}}
        <div class="p-6 flex flex-col justify-between w-full">
            <div class="space-y-4">
                {{-- TITLE --}}
                <div>
                    <a
                            :href="'/properties/' + property.slug"
                            class="text-lg font-semibold text-slate-800 dark:text-slate-100 hover:text-green-600
                   transition-colors duration-300 block"
                            x-text="property.title"
                    ></a>
                </div>

                {{-- PRICE --}}
                <div>
                    <span class="text-slate-400 text-sm">Price</span>
                    <p class="text-xl font-medium text-green-700 dark:text-green-400" x-text="`PKR: ${property.price.toLocaleString()}`"></p>
                </div>

                {{-- LOCATION --}}
                <div class="flex items-center text-slate-500 dark:text-slate-400">
                    <i class="uil uil-map-marker text-2xl me-2 text-green-600"></i>
                    <span x-text="property.location ?? 'n/a'"></span>
                </div>

                {{-- ATTRIBUTES --}}
                <ul
                        class="flex items-center space-x-6 border-y border-slate-100 dark:border-gray-800 py-4 text-slate-600 dark:text-slate-300"
                >
                    <li class="flex items-center space-x-2">
                        <i class="uil uil-compress-arrows text-2xl text-green-600"></i>
                        <span x-text="property.size + ' sqft'"></span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="uil uil-bed-double text-2xl text-green-600"></i>
                        <span x-text="property.beds + ' Beds'"></span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="uil uil-bath text-2xl text-green-600"></i>
                        <span x-text="property.baths + ' Baths'"></span>
                    </li>
                </ul>
            </div>

            {{-- BUTTONS --}}
            <div class="mt-6 flex flex-wrap gap-3">
                <a
                        :href="'tel:' + property.phone"
                        class="flex-1 text-center rounded-full border border-blue-500 text-blue-500 bg-white
                 hover:bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700
                 px-4 py-2 text-sm font-medium transition-colors duration-300"
                >
                    CALL
                </a>

                <a
                        :href="'https://wa.me/' + property.whatsapp_number"
                        target="_blank"
                        class="flex-1 text-center rounded-full bg-green-600 text-white hover:bg-green-700
                 px-4 py-2 text-sm font-medium transition-colors duration-300"
                >
                    WHATSAPP
                </a>

                <a
                        :href="'/properties/' + property.slug"
                        class="flex-1 text-center rounded-full bg-blue-600 text-white hover:bg-blue-700
                 px-4 py-2 text-sm font-medium transition-colors duration-300"
                >
                    VIEW DETAILS
                </a>

                {{-- Example: extra “Favorite” button (optional) --}}
                <button
                        @click="toggleFavorite(property.id)"
                        class="flex-1 text-center rounded-full border border-gray-300 text-gray-600 hover:border-red-500 hover:text-red-500
                 px-4 py-2 text-sm font-medium transition-colors duration-300"
                >
                    <i data-feather="heart" class="inline-block w-4 h-4 me-1"></i>
                    Favorite
                </button>
            </div>
        </div>
    </div>
</div>
