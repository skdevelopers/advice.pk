<div
        class="group rounded-xl bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl
           dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700
           overflow-hidden ease-in-out duration-500 w-full mx-auto"
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
                        x-on:error="$event.target.src = '{{ asset("assets/admin/images/hero.jpg") }}'"
                >
            </div>

            {{-- Top-right badge (“Sale”) --}}
            <div class="absolute top-4 end-4">
                <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                    Sale
                </span>
            </div>

            {{-- Bottom-left: view count + photo count --}}
            <div class="absolute bottom-4 start-4 flex items-center space-x-2">
                <div class="flex items-center bg-black bg-opacity-50 rounded px-2 py-1 text-white text-xs">
                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                    <span x-text="property.views ?? 0"></span>
                </div>
                <div class="flex items-center bg-black bg-opacity-50 rounded px-2 py-1 text-white text-xs">
                    <i data-feather="camera" class="w-4 h-4 mr-1"></i>
                    <span x-text="(property.gallery_urls && property.gallery_urls.length) ? property.gallery_urls.length : 0"></span>
                </div>
            </div>

            {{-- Bottom-right: Property ID --}}
            <div class="absolute bottom-4 end-4 bg-black bg-opacity-50 text-white text-xs font-medium px-2 py-1 rounded">
                P-ID: <span x-text="property.id"></span>
            </div>
        </div>

        {{-- DETAILS SECTION --}}
        <div class="p-6 w-full flex flex-col justify-between">
            <div class="md:pb-4 pb-6">
                <a
                        :href="'/properties/' + property.slug"
                        class="text-lg hover:text-green-600 font-medium ease-in-out duration-500 block"
                        x-text="property.title"
                ></a>
            </div>

            <div class="mb-2">
                <span class="text-slate-400">Price</span>
                <p class="text-lg font-medium" x-text="property.price"></p>
            </div>

            <div class="mb-4">
                <span class="text-slate-400 flex items-center">
                    <i class="uil uil-map-marker text-2xl me-2 text-green-600"></i>
                    <span x-text="property.location ?? 'n/a'"></span>
                </span>
            </div>

            <ul class="md:py-4 py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">
                <li class="flex items-center me-4">
                    <i class="uil uil-compress-arrows text-2xl me-2 text-green-600"></i>
                    <span x-text="property.area"></span>
                </li>
                <li class="flex items-center me-4">
                    <i class="uil uil-bed-double text-2xl me-2 text-green-600"></i>
                    <span x-text="property.beds"></span>
                </li>
                <li class="flex items-center">
                    <i class="uil uil-bath text-2xl me-2 text-green-600"></i>
                    <span x-text="property.baths"></span>
                </li>
            </ul>

            <div class="mt-6 flex space-x-3">
                <a
                        :href="'tel:' + property.phone"
                        class="flex-1 btn border border-blue-500 text-blue-500 hover:bg-blue-50
                           rounded-md text-center py-2 font-medium ease-in-out duration-300"
                >
                    CALL
                </a>

                <a
                        :href="'https://wa.me/' + property.whatsapp_number"
                        target="_blank"
                        class="flex-1 btn bg-green-600 hover:bg-green-700 text-white rounded-md
                           text-center py-2 font-medium ease-in-out duration-300"
                >
                    WHATSAPP
                </a>

                <a
                        :href="'/properties/' + property.slug"
                        class="flex-1 btn bg-blue-600 hover:bg-blue-700 text-white rounded-md
                           text-center py-2 font-medium ease-in-out duration-300"
                >
                    More Detail
                </a>
            </div>
        </div>
    </div>
</div>
