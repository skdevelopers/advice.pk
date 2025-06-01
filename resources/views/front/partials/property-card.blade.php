{{-- resources/views/front/partials/property-card.blade.php --}}
<div class="group rounded-xl bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 w-full mx-auto">
    <div class="md:flex">
        <div class="relative md:shrink-0">
            <img class="size-full object-cover md:w-48" :src="property.property_image" alt="">
            <div class="absolute top-4 end-4">
                <a href="javascript:void(0)" class="btn btn-icon bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 !rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600">
                    <i class="mdi mdi-heart text-[20px]"></i>
                </a>
            </div>
        </div>
        <div class="p-6 w-full">
            <div class="md:pb-4 pb-6">
                <a :href="'/properties/' + property.slug" class="text-lg hover:text-green-600 font-medium ease-in-out duration-500" x-text="property.title"></a>
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
            <ul class="md:pt-4 pt-6 flex justify-between items-center list-none">
                <li>
                    <span class="text-slate-400">Price</span>
                    <p class="text-lg font-medium" x-text="property.price"></p>
                </li>
                <li>
                    <span class="text-slate-400">Rating</span>
                    <ul class="text-lg font-medium text-amber-400 list-none">
                        <li class="inline"><i class="mdi mdi-star"></i></li>
                        <li class="inline"><i class="mdi mdi-star"></i></li>
                        <li class="inline"><i class="mdi mdi-star"></i></li>
                        <li class="inline"><i class="mdi mdi-star"></i></li>
                        <li class="inline"><i class="mdi mdi-star"></i></li>
                        <li class="inline text-slate-900 dark:text-white">5.0</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
