@extends('front.layouts.app')

@section('title', 'Advice Associates | Real Estate Landing')
@once
    @push('head')
        <link rel="preload" as="image" fetchpriority="high"
              href="{{ $featuredProperties[0]['property_image_url'] ?? asset('assets/front/images/placeholder.jpg') }}">
        <script>
            // Keep your existing placeholder
            window.PLACEHOLDER_IMG = window.PLACEHOLDER_IMG
                || '{{ asset("assets/front/images/placeholder.jpg") }}';

            window.renderPropertyCard = function(property) {
                const {
                    title = 'Advice Associates',
                    property_image_url,
                    slug = '#',
                    price = 0,
                    views = 0,
                    gallery_count = 0,
                    id = 0,
                    beds = 0,
                    baths = 0,
                    plot_size = '',
                    today_deal = false,
                    purpose = '',
                    phone = '',
                    whatsapp_number = ''
                } = property;

                const PH       = window.PLACEHOLDER_IMG;
                const imgSrc   = property_image_url || PH;
                const fmtPrice = new Intl.NumberFormat().format(price);

                // Badge (top-right)
                const badge = (today_deal || purpose === 'sale') ? 'SALE'
                    : (purpose === 'rent') ? 'RENT' : '';

                const badgeHtml = badge ? `
      <div class="absolute inset-0 z-20 p-2 pointer-events-none">
        <div class="flex justify-end items-start">
          <span class="pointer-events-auto bg-green-600 text-white text-xs font-semibold uppercase px-2 py-1 rounded-full">
            ${badge}
          </span>
        </div>
      </div>` : '';

                return `
      <div class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500 flex flex-col h-full">

        <!-- IMAGE + OVERLAYS -->
        <div class="relative isolate w-full aspect-square overflow-hidden">
          <img
            src="${imgSrc}"
            alt="${title}"
            loading="lazy"
            onerror="this.onerror=null;this.src='${PH}'"
            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105 z-0"
          />

          ${badgeHtml}

          <!-- bottom-left: views + photos -->
          <div class="absolute inset-0 z-20 p-2 pointer-events-none">
            <div class="flex h-full w-full items-end justify-start">
              <div class="pointer-events-auto bg-black/60 text-white text-xs rounded-full px-2 py-1 flex items-center space-x-3">
                <span class="flex items-center gap-1">
                  <i class="uil uil-eye"></i><span>${views}</span>
                </span>
                <span class="flex items-center gap-1">
                  <i class="uil uil-camera"></i><span>${gallery_count}</span>
                </span>
              </div>
            </div>
          </div>

          <!-- bottom-right: P-ID with property icon -->
          <div class="absolute inset-0 z-20 p-2 pointer-events-none">
            <div class="flex h-full w-full items-end justify-end">
              <div class="pointer-events-auto bg-black/60 text-white text-xs rounded-full px-2 py-1 flex items-center gap-1">
                <i class="uil uil-building"></i>
                <span>P-ID: ${id}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- DETAILS & BUTTONS -->
        <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
          <div>
            <a href="/properties/${slug}" class="block text-lg font-medium mb-2 hover:text-green-600 transition line-clamp-2">
              ${title}
            </a>

            <div class="text-xl font-bold text-green-600 mb-1">
              PKR: ${fmtPrice}${purpose === 'rent' ? ' / M' : ''}
            </div>

            <ul class="flex items-center space-x-6 text-slate-600 dark:text-slate-300 text-sm mb-4">
              <li class="flex items-center gap-1">
                <i class="uil uil-compress-arrows text-green-600 text-xl"></i>
                <span>${plot_size}</span>
              </li>
              <li class="flex items-center gap-1">
                <i class="uil uil-bed-double text-green-600 text-xl"></i>
                <span>${beds}</span>
              </li>
              <li class="flex items-center gap-1">
                <i class="uil uil-bath text-green-600 text-xl"></i>
                <span>${baths}</span>
              </li>
            </ul>
          </div>

          <div class="mt-6 flex items-center gap-2">
            <a href="${phone ? `tel:${phone}` : '#'}"
               class="btn btn-icon border border-blue-500 text-blue-500 rounded-full p-2">
              <i class="uil uil-phone text-lg"></i>
            </a>
            <a href="${whatsapp_number ? `https://wa.me/${whatsapp_number}` : '#'}" target="_blank"
               class="btn btn-icon bg-green-600 text-white rounded-full p-2">
              <i class="uil uil-whatsapp text-lg"></i>
            </a>
            <a href="/properties/${slug}"
               class="btn flex-1 text-sm text-center border border-blue-500 text-blue-500 rounded-full py-2 px-4">
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
