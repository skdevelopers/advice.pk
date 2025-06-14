@props(['property'])

<div class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500 flex flex-col h-full">
    <div class="relative w-full aspect-square overflow-hidden">
        {{-- Responsive Image --}}
        @if (!empty($property['property_image_responsive']))
            <picture>
                <source
                        srcset="{{ collect($property['property_image_responsive'])->map(fn($url, $i) => "{$url} " . (300 + $i * 60) . "w")->join(', ') }}"
                        sizes="(max-width:640px)100vw,(max-width:1024px)50vw,33vw"
                        type="image/webp"
                >
                <img
                        src="{{ $property['property_image_url'] }}"
                        alt="{{ $property['title'] }}"
                        loading="lazy"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                        style="aspect-ratio:1/1;"
                        onerror="this.onerror=null;this.src=window.PLACEHOLDER_IMG;"
                >
            </picture>
        @else
            <img src="{{ asset('assets/admin/images/property/placeholder.jpg') }}"
                 alt="placeholder"
                 class="w-full h-full object-cover object-center"
                 style="aspect-ratio:1/1;">
        @endif

        {{-- Sale/Rent Badge --}}
        @if ($property['today_deal'] ?? false || ($property['purpose'] ?? '') === 'rent')
            <div class="absolute top-3 right-3 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                {{ $property['today_deal'] ? 'Sale' : 'Rent' }}
            </div>
        @endif

        {{-- Overlay Stats Bar --}}
        <div class="absolute bottom-0 w-full bg-black bg-opacity-60 flex justify-between items-center text-white text-sm px-4 py-2">
            <div class="flex gap-4">
                <span class="flex items-center gap-1"><i class="uil uil-eye"></i>{{ $property['views'] ?? 0 }}</span>
                <span class="flex items-center gap-1"><i class="uil uil-camera"></i>{{ $property['gallery_count'] ?? 0 }}</span>
            </div>
            <div class="text-xs font-medium">P‑ID: {{ $property['id'] }}</div>
        </div>
    </div>

    <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
        <div>
            <div class="text-xl font-bold text-green-600 mb-2">PKR: {{ number_format($property['price']) }}</div>
            <div class="text-gray-600 dark:text-gray-300 mb-4 text-sm flex items-center"><i class="uil uil-location-pin mr-1"></i>{{ $property['location'] }}</div>
            <a href="/properties/{{ $property['slug'] }}" class="block text-lg font-medium mb-2 hover:text-green-600 transition line-clamp-2">{{ $property['title'] }}</a>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row sm:gap-2 gap-2">
            <a href="tel:{{ $property['phone'] ?? '#' }}"
               class="btn border border-blue-500 text-blue-500 !rounded-full px-4 py-2 text-sm text-center w-full sm:w-auto">CALL</a>

            <a href="https://wa.me/{{ $property['whatsapp_number'] ?? '' }}"
               target="_blank"
               class="btn bg-green-600 text-white !rounded-full px-4 py-2 text-sm text-center w-full sm:w-auto">WHATSAPP</a>

            <a href="/properties/{{ $property['slug'] }}"
               class="btn bg-blue-600 text-white !rounded-full px-4 py-2 text-sm text-center w-full sm:w-auto">More Detail</a>
        </div>
    </div>
</div>
