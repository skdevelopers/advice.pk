@extends('front.layouts.app')

@section('title', 'Advice Associates | Real Estate Landing')
@once
    @push('head')
        <link rel="preload"
              as="image"
              fetchpriority="high"
              href="{{ $featuredProperties[0]['property_image_url'] ?? asset('assets/admin/images/property/placeholder.jpg') }}">
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
        window.renderPropertyCard = function (property) {
            return `
            <div class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500 flex flex-col h-full">
                <div class="relative w-full aspect-square overflow-hidden">
                    <img src="${property.property_image_url}" alt="Featured Property"
                        loading="lazy"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                        style="aspect-ratio: 1 / 1"
                        onerror="this.src=window.PLACEHOLDER_IMG" />
                    ${(property.today_deal || property.purpose === 'rent')
                ? `<div class="absolute top-3 right-3 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">${property.today_deal ? 'Sale' : 'Rent'}</div>`
                : ''}
                </div>
                <div class="p-6 flex flex-col flex-1 justify-between text-slate-900 dark:text-slate-100">
                    <div>
                        <a href="/properties/${property.slug}"
                            class="block text-lg font-medium mb-2 hover:text-green-600 transition line-clamp-2">${property.title}</a>
                        <div class="mb-4">
                            <span class="text-sm text-slate-400">Price</span>
                            <p class="text-xl font-bold text-green-600">PKR: ${new Intl.NumberFormat().format(property.price)}</p>
                        </div>
                        <ul class="flex items-center space-x-6 text-slate-600 dark:text-slate-300">
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-compress-arrows text-xl text-green-600"></i>
                                <span>${property.plot_size}</span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-bed-double text-xl text-green-600"></i>
                                <span>${property.beds || 0} Beds</span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="uil uil-bath text-xl text-green-600"></i>
                                <span>${property.baths || 0} Baths</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <a href="tel:${property.phone || '#'}" class="btn border border-blue-500 text-blue-500 !rounded-full px-4 py-2 text-sm hidden sm:inline">CALL</a>
                        <a href="https://wa.me/${property.whatsapp_number || ''}" target="_blank" class="btn bg-green-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline">WHATSAPP</a>
                        <button type="button" onclick="window.location.href = '/properties/${property.slug}'" class="btn bg-blue-600 text-white !rounded-full px-4 py-2 text-sm hidden sm:inline">VIEW DETAILS</button>
                    </div>
                </div>
            </div>
        `;
        }
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
