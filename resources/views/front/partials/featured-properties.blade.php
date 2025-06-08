{{-- resources/views/front/partials/featured-properties.blade.php --}}
<section class="container mx-auto mt-16" x-data="featuredProperties()" x-init="fetch()">
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties without any agent or commissions.
        </p>
    </div>

    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-[30px]">
        <template x-for="property in properties" :key="property.id">
            <div
                    class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm
                       hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700
                       transition ease-in-out duration-500"
            >
                {{-- IMAGE WRAPPER: fixed 16:9 --}}
                <div class="relative w-full aspect-video overflow-hidden">
                    <img
                            x-bind:src="
                          property.property_image_responsive.length
                            ? property.property_image_responsive[0]
                            : '{{ asset('assets/admin/images/property/placeholder.jpg') }}'
                        "
                            alt="Featured Property Image"
                            class="w-full h-full object-cover object-center
                               transition-transform duration-500 group-hover:scale-105"
                            x-on:error="
                          $event.target.src='{{ asset('assets/admin/images/property/placeholder.jpg') }}'
                        "
                    >

                    {{-- Sale / Rent badge --}}
                    <template x-if="property.today_deal || property.purpose === 'rent'">
                        <div
                                class="absolute top-4 right-4 bg-green-600 text-white text-xs font-semibold
                                   px-2 py-1 rounded"
                                x-text="property.today_deal ? 'Sale' : 'Rent'"
                        ></div>
                    </template>
                </div>

                {{-- DETAILS --}}
                <div class="p-6 flex flex-col justify-between h-full">
                    {{-- Address / Title --}}
                    <div class="mb-4">
                        <a
                                :href="'/properties/' + property.slug"
                                class="text-lg font-medium text-slate-900 dark:text-white
                                   hover:text-green-600 transition duration-300 block"
                                x-text="property.title"
                        ></a>

                        {{-- Price --}}
                        <div class="mt-2">
                            <span class="text-slate-400 text-sm">Price</span>
                            <p
                                    class="text-xl font-bold text-green-600"
                                    x-text="`PKR: ${new Intl.NumberFormat().format(property.price)}`"
                            ></p>
                        </div>

                        {{-- Icons: size / beds / baths --}}
                        <ul class="mt-4 flex items-center space-x-6 text-slate-600 dark:text-slate-300">
                            <li class="flex items-center space-x-2">
                                <i class="uil uil-compress-arrows text-2xl text-green-600 me-2"></i>
                                <span x-text="property.area ? property.area + ' marla' : '–'"></span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="uil uil-bed-double text-2xl text-green-600 me-2"></i>
                                <span x-text="(property.beds || 0) + ' Beds'"></span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="uil uil-bath text-2xl text-green-600 me-2"></i>
                                <span x-text="(property.baths || 0) + ' Baths'"></span>
                            </li>
                        </ul>
                    </div>

                    {{-- CALL / WHATSAPP / DETAILS --}}
                    <div class="mt-auto flex flex-wrap gap-3">
                        <a
                                :href="'tel:' + property.phone"
                                class="btn border border-blue-500 text-blue-500 !rounded-full
                                   px-4 py-2 text-sm hidden sm:inline"
                        >
                            CALL
                        </a>
                        <a
                                :href="'https://wa.me/' + property.whatsapp_number"
                                target="_blank"
                                class="btn bg-green-600 text-white !rounded-full
                                   px-4 py-2 text-sm hidden sm:inline"
                        >
                            WHATSAPP
                        </a>
                        <a
                                :href="'/properties/' + property.slug"
                                class="btn bg-blue-600 text-white !rounded-full
                                   px-4 py-2 text-sm hidden sm:inline"
                        >
                            VIEW DETAILS
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- No results / Loading --}}
    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">
        No properties found.
    </div>
    <div class="text-center pt-10" x-show="loading">
        Loading...
    </div>

    {{-- View More link --}}
    <div class="text-center mt-8">
        <a href="/properties" class="btn text-green-600 hover:text-green-700 !rounded-full">
            View More Properties &rarr;
        </a>
    </div>
</section>
