@extends('front.layouts.app')

@section('title', 'Advice Associates | Real Estate Landing')

@section('content')
    {{-- Hero Section --}}
    <section class="relative mt-20">
        <div class="container-fluid md:mx-4 mx-2">
            <div class="relative pt-40 pb-52 table w-full rounded-2xl shadow-md overflow-hidden" id="home">
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="container relative">
                    <div class="grid grid-cols-1">
                        <div class="md:text-start text-center">
                            <h1 class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">
                                We will help you find <br> your <span class="text-green-600">Wonderful</span> home
                            </h1>
                            <p class="text-white/70 text-xl max-w-xl">
                                A great platform to buy, sell and rent your properties without any agent or commissions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Search Tabs (Buy/Sell/Rent) --}}
    <section class="relative md:pb-24 pb-16" x-data="propertyTabs()" x-init="init()">
        <div class="container relative">
            {{-- Tabs --}}
            <ul class="flex space-x-2 bg-white rounded-t-xl border-b border-gray-200 p-4">
                <li><button @click="tab='buy'" :class="tab==='buy' ? 'text-green-600' : ''" class="px-6 py-2 font-medium">Buy</button></li>
                <li><button @click="tab='sell'" :class="tab==='sell' ? 'text-green-600' : ''" class="px-6 py-2 font-medium">Sell</button></li>
                <li><button @click="tab='rent'" :class="tab==='rent' ? 'text-green-600' : ''" class="px-6 py-2 font-medium">Rent</button></li>
            </ul>
            <div class="p-6 bg-white rounded-b-xl shadow-md">
                {{-- Tabs Content --}}
                <div x-show="tab==='buy'">
                    @include('front.partials.property-search-form', ['type' => 'buy'])
                </div>
                <div x-show="tab==='sell'" x-cloak>
                    @include('front.partials.property-search-form', ['type' => 'sell'])
                </div>
                <div x-show="tab==='rent'" x-cloak>
                    @include('front.partials.property-search-form', ['type' => 'rent'])
                </div>
            </div>
        </div>

        {{-- Featured Properties (Loaded with Axios) --}}
        <div class="container relative lg:mt-24 mt-16" x-data="featuredProperties()" x-init="fetch()">
            <div class="grid grid-cols-1 pb-8 text-center">
                <h3 class="mb-4 md:text-3xl text-2xl font-semibold">Featured Properties</h3>
                <p class="text-slate-400 max-w-xl mx-auto">A great platform to buy, sell and rent your properties without any agent or commissions.</p>
            </div>
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-6">
                <template x-for="property in properties" :key="property.id">
                    <div class="group rounded-xl bg-white shadow hover:shadow-xl overflow-hidden duration-500">
                        <div class="relative">
                            <img :src="property.image_url" alt="" class="w-full h-64 object-cover">
                            <div class="absolute top-4 right-4">
                                <button class="btn btn-icon bg-white shadow rounded-full text-red-600"><i class="mdi mdi-heart text-lg"></i></button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="pb-6">
                                <a :href="'/property/' + property.slug" class="text-lg hover:text-green-600 font-medium duration-500" x-text="property.title"></a>
                            </div>
                            <ul class="py-6 border-y flex items-center">
                                <li class="flex items-center mr-4"><i class="uil uil-compress-arrows text-2xl mr-2 text-green-600"></i><span x-text="property.area"></span></li>
                                <li class="flex items-center mr-4"><i class="uil uil-bed-double text-2xl mr-2 text-green-600"></i><span x-text="property.beds"></span></li>
                                <li class="flex items-center"><i class="uil uil-bath text-2xl mr-2 text-green-600"></i><span x-text="property.baths"></span></li>
                            </ul>
                            <ul class="pt-6 flex justify-between items-center">
                                <li>
                                    <span class="text-slate-400">Price</span>
                                    <p class="text-lg font-medium" x-text="property.price"></p>
                                </li>
                                <li>
                                    <span class="text-slate-400">Rating</span>
                                    <span class="text-lg font-medium text-amber-400" x-text="property.rating"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
                <div x-show="loading" class="col-span-full text-center py-10">Loading...</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function propertyTabs() {
            return {
                tab: 'buy',
                init() {
                    // Could load some initial data if required
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
