@extends('front.layouts.app')

@section('title', 'Advice Associates | Real Estate AI CRM')

@once
    @push('head')
        @if(!empty($featuredProperties[0]['property_image_url']))
            <link rel="preload" as="image" fetchpriority="high" href="{{ $featuredProperties[0]['property_image_url'] }}">
        @endif
        <script>
            window.PLACEHOLDER_IMG = window.PLACEHOLDER_IMG || @json(asset('assets/front/images/placeholder.jpg'));
            window.renderPropertyCard = function (property) {
                const {
                    title = 'Advice Associates AI CRM',
                    property_image_url,
                    slug = '#',
                    price = 0, views = 0, gallery_count = 0, id = 0,
                    beds = 0, baths = 0, plot_size = '',
                    today_deal = false, purpose = '',
                    phone = '', whatsapp_number = ''
                } = property;

                const PH = window.PLACEHOLDER_IMG;
                const imgSrc = property_image_url || PH;
                const fmtPrice = new Intl.NumberFormat().format(price);
                const badge = (today_deal || purpose === 'sale') ? 'SALE' : (purpose === 'rent') ? 'RENT' : '';

                return `
                        <div class="group relative rounded-2xl bg-white dark:bg-slate-900 shadow-sm transition-all duration-300
                                    hover:shadow-xl hover:-translate-y-1 hover:ring-2 hover:ring-green-500/20
                                    ring-offset-1 ring-offset-white dark:ring-offset-slate-900
                                    dark:shadow-gray-700 dark:hover:shadow-gray-700 dark:hover:ring-green-400/30 flex flex-col h-full">

                          <div class="overflow-hidden rounded-2xl rounded-b-none">
                            <div class="relative isolate w-full aspect-square bg-slate-100 dark:bg-slate-800">
                              <img src="${imgSrc}" alt="${title}" loading="lazy"
                                   onerror="this.onerror=null;this.src='${PH}'"
                                   class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-500 ease-in-out group-hover:scale-105 z-0" />

                              ${badge ? `
                              <div class="absolute inset-0 z-20 p-2 pointer-events-none flex items-start justify-end">
                                <span class="pointer-events-auto bg-green-600 text-white text-xs font-semibold uppercase px-3 py-2 rounded-sm">${badge}</span>
                              </div>` : ''}

                              <div class="absolute inset-0 z-20 p-2 pointer-events-none flex items-end justify-start">
                                <div class="pointer-events-auto bg-black/60 text-white text-xs rounded-full px-3 py-1 flex items-center gap-3">
                                  <span class="flex items-center gap-1"><i class="uil uil-eye"></i><span>: ${views}</span></span>
                                  <span class="flex items-center gap-1"><i class="uil uil-camera"></i><span>: ${gallery_count}</span></span>
                                </div>
                              </div>

                              <div class="absolute inset-0 z-20 p-2 pointer-events-none flex items-end justify-end">
                                <div class="pointer-events-auto bg-black/60 text-white text-xs rounded-full px-3 py-1 flex items-center gap-1">
                                  <i class="uil uil-postcard"></i><span>: ${id}</span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
                            <div>
                              <a href="/properties/${slug}"
                                 class="block text-lg font-medium mb-2 text-slate-900 dark:text-white hover:text-green-600 transition-colors duration-300 line-clamp-2">
                                ${title}
                              </a>

                              <div class="text-xl font-bold text-green-600 mb-1">
                                PKR: ${fmtPrice}${purpose === 'rent' ? ' / M' : ''}
                              </div>

                              <ul class="flex items-center gap-3 text-slate-600 dark:text-slate-300 text-sm mb-4">
                                <li class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-lg">
                                  <i class="uil uil-compress-arrows text-green-600 text-xl"></i><span class="font-medium">${plot_size}</span>
                                </li>
                                <li class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-lg">
                                  <i class="uil uil-bed-double text-green-600 text-xl"></i><span>${beds}</span>
                                </li>
                                <li class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-lg">
                                  <i class="uil uil-bath text-green-600 text-xl"></i><span>${baths}</span>
                                </li>
                              </ul>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                              <a href="${phone ? `tel:${phone}` : '#'}"
                                 class="inline-flex items-center justify-center rounded-xl p-3 border border-blue-200 text-blue-700
                                        bg-blue-50 hover:bg-blue-100 hover:border-blue-400
                                        dark:bg-blue-800 dark:hover:bg-blue-700 dark:border-blue-600 dark:hover:border-blue-500 dark:text-white
                                        transition-all duration-300 shadow-sm hover:shadow-md">
                                <i class="uil uil-phone text-lg"></i>
                              </a>

                              <a href="${whatsapp_number ? `https://wa.me/${whatsapp_number}` : '#'}" target="_blank" rel="noopener"
                                 class="inline-flex items-center justify-center rounded-xl p-3 border border-green-600 text-green-700
                                        hover:bg-green-200
                                        dark:bg-green-800 dark:hover:bg-green-700 dark:border-green-600 dark:hover:border-green-500 dark:text-white
                                        transition-all duration-300 shadow-sm hover:shadow-md">
                                <i class="uil uil-whatsapp text-lg"></i>
                              </a>

                              <a href="/properties/${slug}"
                                 class="inline-flex items-center justify-center rounded-xl py-3 px-4 text-sm font-medium
                                        border border-slate-200 text-slate-700 bg-slate-50
                                        hover:bg-slate-100 hover:border-slate-400
                                        dark:bg-slate-800 dark:hover:bg-slate-700 dark:border-slate-600 dark:hover:border-slate-500 dark:text-white
                                        transition-all duration-300 shadow-sm hover:shadow-md">
                                More
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
                    axios.get('/api/properties/options').then(res => {
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
                        .then(res => { this.results = res.data.data || []; })
                        .catch(() => { this.results = []; })
                        .finally(() => { this.loading = false; });
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
                        .then(res => { this.properties = res.data.data || []; })
                        .catch(() => { this.properties = []; })
                        .finally(() => { this.loading = false; });
                }
            }
        }
    </script>
@endpush
