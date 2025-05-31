@extends('front.layouts.app')
@section('title', 'Advice Associates | Real Estate Landing')
@section('content')
    @include('front.partials.hero')
    @include('front.partials.property-tabs')
    @include('front.partials.featured-properties')
@endsection

@push('scripts')
    <script>
        function propertyTabs() {
            return {
                tab: 'buy'
            }
        }
        function propertySearch(type) {
            return {
                search: { keyword: '', category: '', min_price: '', max_price: '', type: type },
                options: { categories: [], min_prices: [], max_prices: [] },
                loading: false,
                results: [],
                searched: false,
                loadOptions() {
                    axios.get('/api/properties/options')
                        .then(res => {
                            this.options = res.data;
                            this.$nextTick(() => {
                                // Choices.js - re-initialize for dynamically rendered selects
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

