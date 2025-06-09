{{-- resources/views/front/partials/featured-properties.blade.php --}}
<section
        class="container mx-auto px-4 sm:px-6 lg:px-8 mt-16"
        x-data="featuredProperties()"
        x-init="fetch()"
>
    <div class="text-center mb-8">
        <h3 class="md:text-3xl text-2xl font-semibold">Featured Properties</h3>
        <p class="text-slate-400 max-w-xl mx-auto">
            A great platform to buy, sell and rent your properties without any agent or commissions.
        </p>
    </div>

    {{-- 30px gutters & stretch all cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px] items-stretch">
        <template x-for="property in properties" :key="property.id">
            <div
                    class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden
               shadow-sm hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700
               transition duration-500 flex flex-col h-full"
            >
                {{-- square image --}}
                <div class="relative w-full aspect-square overflow-hidden">
                    <img
                            x-bind:src="property.property_image_responsive[0]
                        ?? '{{ asset('assets/admin/images/property/placeholder.jpg') }}'"
                            alt="Featured Property"
                            class="w-full h-full object-cover object-center
                   transition-transform duration-500 group-hover:scale-105"
                            x-on:error="$event.target.src='{{ asset('assets/admin/images/property/placeholder.jpg') }}'"
                    >

                    <template x-if="property.today_deal || property.purpose === 'rent'">
                        <div
                                class="absolute top-3 right-3 bg-green-600 text-white text-xs font-semibold
                     px-2 py-1 rounded"
                                x-text="property.today_deal ? 'Sale' : 'Rent'"
                        ></div>
                    </template>
                </div>

                {{-- details --}}
                <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
                    <div>
                        {{-- clamp title to max-2 lines so it won’t grow the card height --}}
                        <a
                                :href="`/properties/${property.slug}`"
                                class="block text-lg font-medium mb-2 hover:text-green-600 transition line-clamp-2"
                                x-text="property.title"
                        ></a>

                        <div class="mb-4">
                            <span class="text-sm text-slate-400">Price</span>
                            <p
                                    class="text-xl font-bold text-green-600"
                                    x-text="`PKR: ${new Intl.NumberFormat().format(property.price)}`"
                            ></p>
                        </div>

                        <ul class="flex items-center space-x-6 text-slate-600 dark:text-slate-300">
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-compress-arrows text-xl text-green-600"></i>
                                <span x-text="property.plot_size ? property.plot_size + ' marla' : '–'"></span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-bed-double text-xl text-green-600"></i>
                                <span x-text="(property.beds||0) + ' Beds'"></span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-bath text-xl text-green-600"></i>
                                <span x-text="(property.baths||0) + ' Baths'"></span>
                            </li>
                        </ul>
                    </div>

                    {{-- buttons --}}
                    <div class="mt-6 flex gap-3">
                        <a
                                :href="`tel:${property.phone}`"
                                class="btn border border-blue-500 text-blue-500 !rounded-full px-4 py-2 text-sm hidden sm:inline"
                        >CALL</a>
                        <a
                                :href="`https://wa.me/${property.whatsapp_number}`"
                                target="_blank"
                                class="btn bg-green-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline"
                        >WHATSAPP</a>

                        {{-- now a real <button> --}}
                        <button
                                type="button"
                                @click="window.location.href = `/properties/${property.slug}`"
                                class="btn bg-blue-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline"
                        >
                            VIEW DETAILS
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- no results / loading --}}
    <div class="text-center pt-10" x-show="properties.length === 0 && !loading">
        No properties found.
    </div>
    <div class="text-center pt-10" x-show="loading">
        Loading...
    </div>

    {{-- view more --}}
    <div class="text-center mt-8">
        <a href="/properties" class="btn text-green-600 hover:text-green-700 !rounded-full">
            View More Properties &rarr;
        </a>
    </div>
</section>
