@extends('front.layouts.app')

@section('title', 'Advice Associates | Real Estate Landing')
@once
    @push('head')
        <link rel="preload"
              as="image"
              fetchpriority="high"
              href="{{ $featuredProperties[0]['property_image_url'] ?? asset('assets/admin/images/property/placeholder.jpg') }}">
        <script>
            window.renderPropertyCard = function(property) {
                // 1) Fallback image
                const PH = '/assets/admin/images/property/placeholder.jpg';

                // 2) Destructure with defaults
                const {
                    title = 'No Title',
                    property_image_url,
                    slug = '#',
                    price = 0,
                    views = 0,
                    gallery_count = 0,
                    id = 0,
                    beds = 0,
                    baths = 0,
                    plot_size = 0,
                    today_deal = false,
                    purpose = '',
                    phone = '#',
                    whatsapp_number = ''
                } = property;

                const imgSrc   = property_image_url || PH;
                const fmtPrice = new Intl.NumberFormat().format(price);

                // 3) SALE / RENT badge
                let badge = '';
                if (today_deal) {
                    badge = `<div class="absolute top-2 right-2 z-30 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">SALE</div>`;
                } else if (purpose === 'rent') {
                    badge = `<div class="absolute top-2 right-2 z-30 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">RENT</div>`;
                }

                return `
                        <div class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl flex flex-col h-full">
                          <!-- IMAGE + OVERLAYS -->
                          <div class="relative w-full aspect-square overflow-hidden">
                            <img
                              src="${imgSrc}"
                              alt="${title}"
                              loading="lazy"
                              onerror="this.src='${PH}'"
                              class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                              style="aspect-ratio:1/1"
                            />
                            ${badge}
                             <span class="flex items-center gap-1"><i class="uil uil-eye"></i>${views}</span>
                            <div class="absolute bottom-0 left-0 right-0 z-20 bg-black bg-opacity-50 text-white text-xs px-3 py-2 flex justify-between items-center">
                              <span class="flex items-center gap-1"><i class="uil uil-eye"></i>${views}</span>
                              <span class="flex items-center gap-1"><i class="uil uil-camera"></i>${gallery_count}</span>
                              <span class="flex items-center gap-1"><i class="uil uil-id-badge"></i>${id}</span>
                            </div>
                          </div>

                          <!-- DETAILS & BUTTONS -->
                          <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
                            <div>
                              <a href="/properties/${slug}" class="block text-lg font-medium mb-2 hover:text-green-600">
                                ${title}
                              </a>
                              <div class="text-green-600 font-bold text-xl mb-3">PKR: ${fmtPrice}</div>
                              <ul class="flex items-center space-x-6 text-slate-600 dark:text-slate-300 text-sm mb-4">
                                <li class="flex items-center gap-1"><i class="uil uil-compress-arrows text-green-600"></i>${plot_size} Marla</li>
                                <li class="flex items-center gap-1"><i class="uil uil-bed-double text-green-600"></i>${beds} Beds</li>
                                <li class="flex items-center gap-1"><i class="uil uil-bath text-green-600"></i>${baths} Baths</li>
                              </ul>
                            </div>
                            <!-- DETAILS & BUTTONS -->
                            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                              <!-- PHONE -->
                              <a
                                href="tel:${property.phone||'#'}"
                                class="btn flex-1 sm:flex-none w-full sm:w-auto border border-blue-500 text-blue-500 rounded-full px-4 py-2 text-sm flex items-center justify-center"
                              >
                                <i class="uil uil-phone mr-2"></i>
                                CALL
                              </a>

                              <!-- WHATSAPP -->
                              <a
                                href="https://wa.me/${property.whatsapp_number||''}"
                                target="_blank"
                                class="btn flex-1 sm:flex-none w-full sm:w-auto bg-green-600 text-white rounded-full px-4 py-2 text-sm flex items-center justify-center"
                              >
                                <i class="uil uil-whatsapp mr-2"></i>
                                WHATSAPP
                              </a>

                              <!-- DETAILS -->
                              <a
                                href="/properties/${property.slug}"
                                class="btn flex-1 sm:flex-none w-full sm:w-auto border border-blue-500 text-blue-500 rounded-full px-4 py-2 text-sm flex items-center justify-center"
                              >
                                <i class="uil uil-angle-right-b mr-2"></i>
                                MORE
                              </a>
                            </div>

                          </div>
                        </div>`;
            };
        </script>
    @endpush
@endonce

@section('content')
    @include('front.partials.hero')
    @include('front.partials.property-tabs')
    @include('front.partials.property-categories')
    @include('front.partials.featured-properties')
    @include('front.partials.videos')
@endsection

@push('scripts')
    <script>

        function propertyTabs() {
            return { tab: 'buy' }
        }

        function propertySearch(type) {
            return {
                search: { keyword: '', category: '', min_price: '', max_price: '', type },
                options: { categories: [], min_prices: [], max_prices: [] },
                loading: false,
                results: [],
                searched: false,
                loadOptions() {
                    axios.get('/api/properties/options')
                        .then(res => {
                            this.options = res.data;
                            this.$nextTick(() => {
                                if (window.Choices) {
                                    if (this.$refs.category) new Choices(this.$refs.category, { searchEnabled: false, itemSelectText: '' });
                                    if (this.$refs.minPrice) new Choices(this.$refs.minPrice, { searchEnabled: false, itemSelectText: '' });
                                    if (this.$refs.maxPrice) new Choices(this.$refs.maxPrice, { searchEnabled: false, itemSelectText: '' });
                                }
                            });
                        });
                },
                searchProperties() {
                    this.loading = true;
                    this.searched = true;
                    axios.get('/api/properties/search', { params: this.search })
                        .then(res => {
                            this.results = res.data.data || [];
                        })
                        .catch(() => {
                            this.results = [];
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            }
        }

        function featuredProperties() {
            return {
                properties: [],
                loading: true,
                fetch() {
                    this.loading = true;
                    axios.get('/api/properties/featured')
                        .then(res => {
                            this.properties = res.data.data || [];
                        })
                        .catch(() => {
                            this.properties = [];
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            }
        }
    </script>
@endpush
