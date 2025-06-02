@extends('front.layouts.app')

@section('title', $property->title ?? 'Property Details')

@section('content')
    <section
            x-data="propertyDetail('{{ $property->slug }}')"
            x-init="fetchProperty()"
            class="relative md:py-24 pt-24 pb-16"
    >
        <div class="container relative">
            <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">

                <!-- LEFT COLUMN: IMAGES + DETAILS + DESCRIPTION + MAP -->
                <div class="lg:col-span-8 md:col-span-7">

                    <!-- GALLERY SLIDER -->
                    <div class="grid grid-cols-1 relative">
                        <!--
                          1) NO static tiny-one-item class here at page load,
                             so Hously’s plugin.init.js will skip auto-init.
                          2) Once images arrive, Alpine adds 'tiny-one-item' dynamically.
                        -->
                        <div
                                x-ref="sliderContainer"
                                x-bind:class="images.length > 0 ? 'tiny-one-item' : ''"
                        ></div>

                        <!-- Loading placeholder while images is still empty -->
                        <div
                                class="text-center text-gray-400 py-10"
                                x-show="loading && images.length === 0"
                        >
                            Loading images...
                        </div>
                    </div>
                    <!-- /END GALLERY SLIDER -->


                    <!-- TITLE + ADDRESS -->
                    <h4 class="text-2xl font-medium mt-6 mb-3" x-text="property.title ?? ''"></h4>
                    <span class="text-slate-400 flex items-center">
                        <i data-feather="map-pin" class="size-5 me-2"></i>
                        <span x-text="property.address ?? ''"></span>
                    </span>

                    <!-- SIZE / BEDS / BATHS -->
                    <ul class="py-6 flex items-center list-none">
                        <li class="flex items-center lg:me-6 me-4">
                            <i class="uil uil-compress-arrows lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span class="lg:text-xl" x-text="property.size"></span>
                        </li>
                        <li class="flex items-center lg:me-6 me-4">
                            <i class="uil uil-bed-double lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span
                                    class="lg:text-xl"
                                    x-text="property.beds ? property.beds + ' Beds' : ''"
                            ></span>
                        </li>
                        <li class="flex items-center">
                            <i class="uil uil-bath lg:text-3xl text-2xl me-2 text-green-600"></i>
                            <span
                                    class="lg:text-xl"
                                    x-text="property.baths ? property.baths + ' Baths' : ''"
                            ></span>
                        </li>
                    </ul>

                    <!-- DESCRIPTION PARAGRAPHS -->
                    <template x-for="(para, idx) in property.description_paragraphs" :key="idx">
                        <p class="text-slate-400 mt-4" x-text="para"></p>
                    </template>

                    <!-- GOOGLE MAP EMBED -->
                    <div class="w-full leading-[0] border-0 mt-6">
                        <iframe
                                x-bind:src="property.map_embed"
                                style="border:0"
                                class="w-full h-[500px]"
                                allowfullscreen
                        ></iframe>
                    </div>
                </div>
                <!-- /LEFT COLUMN -->

                <!-- RIGHT COLUMN: Sidebar (Price/Stats/Buttons/Contact) -->
                <div class="lg:col-span-4 md:col-span-5">
                    <div class="sticky top-20">
                        <div class="rounded-md bg-slate-50 dark:bg-slate-800 shadow-sm dark:shadow-gray-700">
                            <div class="p-6">
                                <h5 class="text-2xl font-medium">Price:</h5>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-medium" x-text="formatCurrency(property.price)"></span>
                                    <span
                                            class="bg-green-600/10 text-green-600 text-sm px-2.5 py-0.75 rounded h-6"
                                            x-text="property.status === 'active' ? 'For Sale' : 'Unavailable'"
                                    ></span>
                                </div>

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
                                    <a href="#"
                                       class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full"
                                    >
                                        Book Now
                                    </a>
                                </div>
                                <div class="p-1 w-1/2">
                                    <a href="#"
                                       class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full"
                                    >
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
                                   class="btn bg-transparent hover:bg-green-600 border border-green-600 text-green-600 hover:text-white rounded-md"
                                >
                                    <i class="uil uil-phone align-middle me-2"></i> Contact us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /RIGHT COLUMN -->

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function propertyDetail(slug) {
            return {
                slug: slug,
                property: {},
                images: [],
                loading: false,

                fetchProperty() {
                    this.loading = true;
                    axios.get(`/api/properties/${this.slug}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                        .then(res => {
                            this.property = res.data.data || {};
                            this.images   = this.property.images || [];
                        })
                        .catch(() => {
                            this.property = {};
                            this.images   = [];
                        })
                        .finally(() => {
                            // 1) Hide the “Loading images” placeholder.
                            this.loading = false;

                            // 2) If we have images, inject them and then init Tiny Slider.
                            if (this.images.length) {
                                // Build slide HTML:
                                const slidesHtml = this.images
                                    .map(img => `
                                <div class="tiny-slide">
                                    <img src="${img.url}"
                                         class="rounded-md shadow-sm dark:shadow-gray-700"
                                         alt="Property image">
                                </div>`
                                    )
                                    .join('');

                                // Inject into the slider container:
                                this.$refs.sliderContainer.innerHTML = slidesHtml;

                                // 3) Add the tiny-one-item class now that slides exist (so Hously's plugin won't auto-init earlier).
                                this.$refs.sliderContainer.classList.add('tiny-one-item');

                                // 4) Initialize Tiny Slider after DOM update:
                                this.$nextTick(() => {
                                    if (window.tns) {
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
                                    if (window.feather) feather.replace();
                                });
                            }
                        });
                },

                formatCurrency(value) {
                    if (typeof value !== 'number') return '';
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PKR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(value);
                }
            }
        }
    </script>
@endpush
