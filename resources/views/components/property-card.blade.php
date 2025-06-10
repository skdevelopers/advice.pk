@props(['property'])

<div
        class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden
           shadow-sm hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700
           transition duration-500 flex flex-col h-full"
>
    <div class="relative w-full aspect-square overflow-hidden">
        @if (!empty($property['property_image_responsive']))
            <picture>
                <source
                        srcset="{{ collect($property['property_image_responsive'])->map(fn($url, $i) => $url . ' ' . (300 + $i * 60) . 'w')->join(', ') }}"
                        sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                        type="image/webp"
                >
                <img
                        src="{{ $property['property_image_url'] }}"
                        alt="Featured Property"
                        loading="lazy"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                        style="aspect-ratio: 1/1;"
                        onerror="this.onerror=null;this.src=window.PLACEHOLDER_IMG;"
                >
            </picture>
        @else
            <img
                    src="{{ asset('assets/admin/images/property/placeholder.jpg') }}"
                    alt="Featured Property"
                    class="w-full h-full object-cover object-center"
                    style="aspect-ratio: 1/1;"
            >
        @endif

        @if ($property['today_deal'] ?? false || ($property['purpose'] ?? '') === 'rent')
            <div class="absolute top-3 right-3 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                {{ ($property['today_deal']) ? 'Sale' : 'Rent' }}
            </div>
        @endif
    </div>

    <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
        <div>
            <a href="/properties/{{ $property['slug'] }}"
               class="block text-lg font-medium mb-2 hover:text-green-600 transition line-clamp-2">
                {{ $property['title'] }}
            </a>

            <div class="mb-4">
                <span class="text-sm text-slate-400">Price</span>
                <p class="text-xl font-bold text-green-600">
                    PKR: {{ number_format($property['price']) }}
                </p>
            </div>

            <ul class="flex items-center space-x-6 text-slate-600 dark:text-slate-300">
                <li class="flex items-center space-x-1">
                    <i class="uil uil-compress-arrows text-xl text-green-600"></i>
                    <span>{{ $property['plot_size'] ?? '–' }} marla</span>
                </li>
                <li class="flex items-center space-x-1">
                    <i class="uil uil-bed-double text-xl text-green-600"></i>
                    <span>{{ $property['beds'] ?? 0 }} Beds</span>
                </li>
                <li class="flex items-center space-x-1">
                    <i class="uil uil-bath text-xl text-green-600"></i>
                    <span>{{ $property['baths'] ?? 0 }} Baths</span>
                </li>
            </ul>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="tel:{{ $property['phone'] ?? '#' }}"
               class="btn border border-blue-500 text-blue-500 !rounded-full px-4 py-2 text-sm hidden sm:inline">
                CALL
            </a>
            <a href="https://wa.me/{{ $property['whatsapp_number'] ?? '' }}"
               target="_blank"
               class="btn bg-green-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline">
                WHATSAPP
            </a>
            <button type="button"
                    onclick="window.location.href = '/properties/{{ $property['slug'] }}'"
                    class="btn bg-blue-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline">
                VIEW DETAILS
            </button>
        </div>
    </div>
</div>
