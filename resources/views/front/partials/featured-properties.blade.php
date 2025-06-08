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
                    class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl
                       dark:shadow-gray-700 dark:hover:shadow-gray-700 transition ease-in-out duration-500"
            >
                {{-- IMAGE WRAPPER --}}
                <div class="relative h-56 w-full overflow-hidden">
                    <img
                            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                            x-bind:src="
                            property.property_image_responsive.length
                                ? property.property_image_responsive[0]
                                : '{{ asset('assets/admin/images/property/placeholder.jpg') }}'
                        "
                            alt="Featured Property Image"
                            x-on:error="$event.target.src = '{{ asset('assets/admin/images/property/placeholder.jpg') }}'"
                    >

                    {{-- “Sale” badge (only if property.purpose == 'sale') --}}
                    <template x-if="property.purpose === 'sale'">
                        <div class="absolute top-4 right-4 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            Sale
                        </div>
                    </template>

                    {{-- You can add a “Rent” badge similarly: --}}
                    {{-- <template x-if="property.purpose === 'rent'">
                        <div class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            Rent
                        </div>
                    </template> --}}
                </div>

                {{-- DETAILS SECTION --}}
                <div class="p-6 flex flex-col justify-between h-full">
                    {{--
                      Here we inject your custom <div class="p-6">…</div> snippet.
                      NOTE: We’ve removed “Rating” and replaced “$5000” with PKR: property.price.
                    --}}
                    <div class="mb-4">
                        <div class="pb-6">
                            <a
                                    :href="'/properties/' + property.slug"
                                    class="text-lg hover:text-green-600 font-medium transition-colors duration-500"
                            >
                                {{-- Display the title (address) --}}
                                <span x-text="property.title"></span>
                            </a>
                        </div>

                        <ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">
                            <li class="flex items-center me-4">
                                <i class="uil uil-compress-arrows text-2xl me-2 text-green-600"></i>
                                <span x-text="property.size ? property.size + ' marla' : '–'"></span>
                            </li>
                            <li class="flex items-center me-4">
                                <i class="uil uil-bed-double text-2xl me-2 text-green-600"></i>
                                <span x-text="property.beds ? property.beds + ' Beds' : '0 Beds'"></span>
                            </li>
                            <li class="flex items-center">
                                <i class="uil uil-bath text-2xl me-2 text-green-600"></i>
                                <span x-text="property.baths ? property.baths + ' Baths' : '0 Baths'"></span>
                            </li>
                        </ul>

                        <ul class="pt-6 flex justify-between items-center list-none">
                            <li>
                                <span class="text-slate-400">Price</span>
                                <p class="text-lg font-medium" x-text="`PKR: ${new Intl.NumberFormat().format(property.price)}`"></p>
                            </li>

                            {{--
                              We remove “Rating” entirely, per your request.
                              If you need to display anything else (e.g. “Views”), you can add it here.
                            --}}
                        </ul>
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

    {{-- “View More Properties” link --}}
    <div class="text-center mt-8">
        <a
                href="/properties"
                class="inline-block text-green-600 hover:text-green-700 font-medium transition duration-300"
        >
            View More Properties &rarr;
        </a>
    </div>
</section>
