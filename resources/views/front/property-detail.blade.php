@extends('front.layouts.app')

@section('title', $property->title ?? 'Property Details')

@section('content')
    <!--
        We’re wrapping everything in an Alpine component called `propertyDetail()`.
        On init, we fire `fetchProperty()` which does `axios.get('/api/properties/{slug}')`.
        We pass the server‐rendered `$property->slug` into Alpine so it knows which endpoint to call.
    -->
    <section x-data="propertyDetail('{{ $property->slug }}')" x-init="fetchProperty()" class="relative md:py-24 pt-24 pb-16">
        <div class="container relative">
            <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">
                <!-- LEFT COLUMN: IMAGES + DETAILS + DESCRIPTION + MAP -->
                <div class="lg:col-span-8 md:col-span-7">
                    <!-- GALLERY SLIDER -->
                    <div class="grid grid-cols-1 relative">
                        <!-- tiny-slider container; we’ll fill it via x-for -->
                        <div class="tiny-one-item" x-ref="sliderContainer" x-show="images.length > 0">
                            <template x-for="(img, idx) in images" :key="idx">
                                <div class="tiny-slide">
                                    <img :src="img.url"
                                         class="rounded-md shadow-sm dark:shadow-gray-700"
                                         alt="Property image">
                                </div>
                            </template>
                        </div>
                        <!-- show a simple “Loading…” until images arrive -->
                        <div class="text-center text-gray-400 py-10" x-show="loading && images.length === 0">
                            Loading images...
                        </div>
                    </div>

                    <!-- TITLE + ADDRESS -->
                    <h4 class="text-2xl font-medium mt-6 mb-3" x-text="property.title ?? '...'"></h4>
                    <span class="text-slate-400 flex items-center">
                        <i data-feather="map-pin" class="size-5 me-2"></i>
                        <span x-text="property.address ?? ''"></span>
                    </span>

                    <!-- SIZE / BEDS / BATHS -->
                    <ul class="py-6 flex items-center list-none">
                        <li class="flex items-center lg:me-6 me-4">
                            <i class="uil uil-compress-arrows lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span class="lg:text-xl" x-text="property.size ? property.size + ' sqf' : ''"></span>
                        </li>

                        <li class="flex items-center lg:me-6 me-4">
                            <i class="uil uil-bed-double lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span class="lg:text-xl" x-text="property.beds ? property.beds + ' Beds' : ''"></span>
                        </li>

                        <li class="flex items-center">
                            <i class="uil uil-bath lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span class="lg:text-xl" x-text="property.baths ? property.baths + ' Baths' : ''"></span>
                        </li>
                    </ul>

                    <!-- DESCRIPTION PARAGRAPHS -->
                    <template x-for="(para, idx) in property.description_paragraphs" :key="idx">
                        <p class="text-slate-400 mt-4" x-text="para"></p>
                    </template>

                    <!-- GOOGLE MAP EMBED -->
                    <div class="w-full leading-[0] border-0 mt-6">
                        <iframe
                                x-bind:src="property.map_embed_url"
                                style="border:0"
                                class="w-full h-[500px]"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <!-- RIGHT COLUMN: SIDEBAR (Price + Stats + Buttons + Contact) -->
                <div class="lg:col-span-4 md:col-span-5">
                    <div class="sticky top-20">
                        <div class="rounded-md bg-slate-50 dark:bg-slate-800 shadow-sm dark:shadow-gray-700">
                            <div class="p-6">
                                <!-- PRICE HEADER -->
                                <h5 class="text-2xl font-medium">Price:</h5>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-medium" x-text="formatCurrency(property.price)"></span>
                                    <span class="bg-green-600/10 text-green-600 text-sm px-2.5 py-0.75 rounded h-6"
                                          x-text="property.status === 'active' ? 'For Sale' : 'Unavailable'">
                                    </span>
                                </div>

                                <!-- STATS LIST -->
                                <ul class="list-none mt-4">
                                    <li class="flex justify-between items-center">
                                        <span class="text-slate-400 text-sm">Days on Market</span>
                                        <span class="font-medium text-sm" x-text="property.days_on_market + ' Days'"></span>
                                    </li>

                                    <li class="flex justify-between items-center mt-2">
                                        <span class="text-slate-400 text-sm">Price per sq ft</span>
                                        <span class="font-medium text-sm" x-text="formatCurrency(property.price_per_sqf)"></span>
                                    </li>

                                    <li class="flex justify-between items-center mt-2">
                                        <span class="text-slate-400 text-sm">Monthly Payment</span>
                                        <span class="font-medium text-sm" x-text="formatCurrency(property.monthly_payment) + '/mo'"></span>
                                    </li>
                                </ul>
                            </div>

                            <!-- ACTION BUTTONS -->
                            <div class="flex">
                                <div class="p-1 w-1/2">
                                    <a href="#" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                                        Book Now
                                    </a>
                                </div>
                                <div class="p-1 w-1/2">
                                    <a href="#" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                                        Offer Now
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT CTA -->
                        <div class="mt-12 text-center">
                            <h3 class="mb-6 text-xl leading-normal font-medium text-slate-900 dark:text-white">
                                Have a question? Get in touch!
                            </h3>
                            <div class="mt-6">
                                <a href="{{ url('contact') }}"
                                   class="btn bg-transparent hover:bg-green-600 border border-green-600 text-green-600 hover:text-white rounded-md">
                                    <i class="uil uil-phone align-middle me-2"></i> Contact us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        /**
         * Alpine component to load a single property’s JSON from /api/properties/{slug}.
         *
         * We pass `slug` from the Blade: it’s the `$property->slug` the controller already found.
         * Once the data arrives, we fill `property` & `images`, then run Tiny Slider on `$refs.sliderContainer`.
         */
        function propertyDetail(slug) {
            return {
                slug: slug,
                property: {},
                images: [],
                loading: false,

                /**
                 * Call this on Alpine.init. It fetches `/api/properties/{slug}`.
                 */
                fetchProperty() {
                    this.loading = true;
                    axios.get(`/api/properties/${this.slug}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                        .then(res => {
                            this.property = res.data.data || {};
                            this.images = this.property.images || [];
                        })
                        .catch(() => {
                            this.property = {};
                            this.images = [];
                        })
                        .finally(() => {
                            this.loading = false;
                            // After images are in the DOM, initialize Tiny Slider:
                            this.$nextTick(() => {
                                if (this.images.length && window.tns) {
                                    tns({
                                        container: this.$refs.sliderContainer,
                                        items: 1,
                                        gutter: 0,
                                        nav: true,
                                        controls: false,
                                        autoplay: true,
                                        autoplayButtonOutput: false,
                                        mouseDrag: true,
                                        loop: true,
                                    });
                                }
                                // Re-run Feather icons
                                if (window.feather) feather.replace();
                            });
                        });
                },

                /**
                 * Helper to format numbers into USD currency.
                 * You can customize if you want “PKR” or anything else.
                 */
                formatCurrency(value) {
                    if (typeof value !== 'number') return '';
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(value);
                }
            }
        }
    </script>
@endpush
