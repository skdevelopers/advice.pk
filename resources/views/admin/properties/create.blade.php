{{-- resources/views/admin/properties/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Create Property')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Property Create</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.properties.create') }}">Add Property</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">
                        Create Property
                    </li>
                </ul>
            </div>

            {{-- Message Area --}}
            <div id="alert-wrapper" class="mb-4"></div>

            <!-- Page Content -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900"
                     x-data="propertyForm()"
                     x-init="init()">

                    <form id="propertyForm" @submit.prevent="submitForm" enctype="multipart/form-data"
                          class="space-y-6">

                        {{-- Hidden fields --}}
                        <input type="hidden" name="user_id" :value="form.user_id">
                        <input type="hidden" name="created_by" :value="form.created_by">

                        {{-- Purpose --}}
                        <fieldset class="space-x-4">
                            <legend class="font-medium">Purpose<span class="text-red-500">*</span></legend>
                            <label><input type="radio" name="purpose" value="sale" x-model="form.purpose" required> Sale</label>
                            <label><input type="radio" name="purpose" value="rent" x-model="form.purpose"> Rent</label>
                            <label><input type="radio" name="purpose" value="instalments" x-model="form.purpose">
                                Instalments</label>
                            <p class="text-red-600" x-text="errors.purpose" x-show="errors.purpose"></p>
                        </fieldset>

                        {{-- Property Type --}}
                        <fieldset class="space-x-4">
                            <legend class="font-medium">Property Type<span class="text-red-500">*</span></legend>
                            <template x-for="type in propertyTypes" :key="type.value">
                                <label>
                                    <input type="radio" name="property_type" :value="type.value"
                                           x-model="form.property_type" required>
                                    <span x-text="type.label"></span>
                                </label>
                            </template>
                            <p class="text-red-600" x-text="errors.property_type" x-show="errors.property_type"></p>
                        </fieldset>

                        {{-- Title & Description --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium">Property Title<span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" x-model="form.title"
                                       class="w-full border rounded px-3 py-2" required>
                                <p class="text-red-600" x-text="errors.title" x-show="errors.title"></p>
                            </div>
                            <div>
                                <label class="block font-medium">Property Description<span class="text-red-500">*</span></label>
                                <textarea name="description" x-model="form.description"
                                          class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                                <p class="text-red-600" x-text="errors.description" x-show="errors.description"></p>
                            </div>
                        </div>

                        {{-- Keywords --}}
                        <div>
                            <label class="block font-medium">Property Keywords<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="keywords" x-model="form.keywords"
                                   class="w-full border rounded px-3 py-2" required>
                            <p class="text-red-600" x-text="errors.keywords" x-show="errors.keywords"></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                            <!-- Society -->
                            <div>
                                <label class="block font-medium">Society<span class="text-red-500">*</span></label>
                                <select name="society_id" x-model="form.society_id" @change="loadSubsectors"
                                        class="w-full border rounded px-3 py-2" required>
                                    <option value="">Select Society</option>
                                    @foreach($societies as $soc)
                                    <option value="{{ $soc->id }}">{{ $soc->society_name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-red-600 text-sm" x-text="errors.society_id"
                                   x-show="errors.society_id"></p>
                            </div>
                            <!-- Sub Sector -->
                            <div x-show="subsectors.length > 0" x-cloak>
                                <label class="block font-medium">Sub Sector<span class="text-red-500">*</span></label>
                                <select name="sub_sector_id" x-model="form.sub_sector_id" @change="loadBlocks"
                                        class="w-full border rounded px-3 py-2" required>
                                    <option value="">Select Sub Sector</option>
                                    <template x-for="subSector in subsectors" :key="subSector.id">
                                        <option :value="subSector.id" x-text="subSector.name"></option>
                                    </template>
                                </select>
                                <p class="text-red-600 text-sm" x-text="errors.sub_sector_id"
                                   x-show="errors.sub_sector_id"></p>
                            </div>
                            <!-- Block -->
                            <div x-show="blockSectors.length > 0" x-cloak>
                                <label class="block font-medium">Sector/Zone/Block</label>
                                <select name="block_sector" x-model="form.block_sector"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="">Select Block</option>
                                    <template x-for="blk in blockSectors" :key="blk.id">
                                        <option :value="blk.id" x-text="blk.name"></option>
                                    </template>
                                </select>
                            </div>
                            <!-- Property Size -->
                            <div>
                                <label class="block font-medium">Property Size<span
                                        class="text-red-500">*</span></label>
                                <select name="plot_size" x-model="form.plot_size"
                                        class="w-full border rounded px-3 py-2" required>
                                    <option value="">Select Size</option>
                                    @foreach($sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>
                                <p class="text-red-600 text-sm" x-text="errors.plot_size" x-show="errors.plot_size"></p>
                            </div>
                        </div>

                        {{-- Instalment Plot Type --}}
                        <div x-show="form.purpose==='instalments'" x-cloak>
                            <label class="block font-medium">Instalment Property Type<span class="text-red-500">*</span></label>
                            <select name="instalment_plot_type" x-model="form.instalment_plot_type"
                                    class="w-full border rounded px-3 py-2">
                                <option value="non_develop">Non Develop</option>
                                <option value="develop">Develop</option>
                                <option value="Possession">Possession</option>
                                <option value="Non Possession">Non Possession</option>
                            </select>
                        </div>

                        {{-- Plot-for-sale fields --}}
                        <div
                                x-show="(form.purpose==='sale' && form.property_type==='plots') || (form.purpose==='instalments' && form.property_type==='plots')"
                                x-cloak
                                class="space-y-4"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block font-medium">Plot Category<span
                                            class="text-red-500">*</span></label>
                                    <select name="plot_type" x-model="form.plot_type"
                                            class="w-full border rounded px-3 py-2">
                                        <option value="">Select Plot Category</option>
                                        @foreach(['residential_plot','commercial_plot','agricultural_land','industrial_land','plot_file','plot_form','shop'] as $opt)
                                        <option value="{{ $opt }}">{{ ucwords(str_replace('_',' ',$opt)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-medium">Street/Floor</label>
                                    <input type="text" name="street" x-model="form.street"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block font-medium">Plot/Shop/Apartment No<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="plot_no" x-model="form.plot_no"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block font-medium">Price<span class="text-red-500">*</span></label>
                                    <input type="number" name="price" x-model="form.price"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                            </div>
                        </div>


                        {{-- Rent fields --}}
                        <div x-show="form.purpose==='rent' && ['homes','farm_houses','shop'].includes(form.property_type)"
                             x-cloak class="space-y-4">
                            <div>
                                <label class="block font-medium">Rent Type<span class="text-red-500">*</span></label>
                                <select name="rent_type" x-model="form.rent_type"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="monthly">Monthly</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium">Rent Amount<span class="text-red-500">*</span></label>
                                <input type="number" name="rent" x-model="form.rent"
                                       class="w-full border rounded px-3 py-2">
                            </div>
                        </div>

                        {{-- House/Apartment fields --}}
                        <div x-show="['homes','farm_houses','apartments','shop'].includes(form.property_type)" x-cloak
                             class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                <template x-for="field in houseFields" :key="field.name">
                                    <div>
                                        <label class="block font-medium"
                                               x-text="field.label + (field.required ? '*' : '')"></label>
                                        <input type="number" :name="field.name" x-model="form[field.name]"
                                               class="w-full border rounded px-3 py-2">
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Public Facilities --}}
                        <div x-show="['homes','farm_houses','apartments','shop'].includes(form.property_type)" x-cloak
                             class="space-y-4 bg-gray-50 p-4 rounded">
                            <h3 class="font-semibold mb-2">Public Facilities (Distance)</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                <template x-for="pf in publicFacilities" :key="pf">
                                    <div>
                                        <label class="block font-medium capitalize"
                                               x-text="pf.replaceAll('_',' ')"></label>
                                        <input type="text" :name="pf.toLowerCase()" x-model="form[pf.toLowerCase()]"
                                               class="w-full border rounded px-3 py-2">
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Instalment details --}}
                        <div x-show="form.purpose==='instalments'" x-cloak class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block font-medium">Downpayment<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="instalments_downpayment"
                                           x-model="form.instalments_downpayment"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block font-medium">Confirmation Price</label>
                                    <input type="text" name="confirmation" x-model="form.confirmation"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block font-medium">First Description<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="instalments_monthly_instalments"
                                           x-model="form.instalments_monthly_instalments"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block font-medium">Second Description<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="instalments_monthly_instalments_price"
                                           x-model="form.instalments_monthly_instalments_price"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                            </div>
                        </div>

                        {{-- Videos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium">YouTube Embed URL</label>
                                <input type="text" name="video" x-model="form.video"
                                       class="w-full border rounded px-3 py-2">
                            </div>
                            <div>
                                <label class="block font-medium">YouTube Short Embed URL</label>
                                <input type="text" name="short_video" x-model="form.short_video"
                                       class="w-full border rounded px-3 py-2">
                            </div>
                        </div>

                        {{-- Flags --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium">Best Selling Property</label>
                                <select name="best_selling_property" x-model="form.best_selling_property"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium">Today Deal</label>
                                <select name="today_deal" x-model="form.today_deal"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium">Send on Social Media</label>
                                <select name="mail_send" x-model="form.mail_send"
                                        class="w-full border rounded px-3 py-2">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                            </div>
                        </div>

                        {{-- Coordinates --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium">Longitude</label>
                                <input type="text" name="longitude" x-model="form.longitude"
                                       class="w-full border rounded px-3 py-2">
                            </div>
                            <div>
                                <label class="block font-medium">Latitude</label>
                                <input type="text" name="latitude" x-model="form.latitude"
                                       class="w-full border rounded px-3 py-2">
                            </div>
                        </div>

                        {{-- MAIN IMAGE --}}
                        <div x-data="{
                                preview: null,
                                handleFileUpload(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = e => this.preview = e.target.result;
                                        reader.readAsDataURL(file);
                                    } else {
                                        this.preview = null;
                                    }
                                }
                            }"
                        >
                            <p class="font-medium mb-4">Upload your main property image here</p>
                            <div class="preview-box flex justify-center items-center rounded-md shadow-sm dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center w-full h-60">
                                <template x-if="preview">
                                    <img :src="preview" class="max-h-60 object-contain rounded-md" alt="Preview">
                                </template>
                                <template x-if="!preview">
                                    <span>Supports JPG, PNG, WEBP. Max file size: 1MB.</span>
                                </template>
                            </div>
                            <input type="file" id="main_image" name="main_image" class="hidden"
                                   accept=".jpg,.jpeg,.webp,.png"
                                   @change="handleFileUpload">
                            <label for="main_image"
                                   class="btn-upload bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-4 px-4 py-2 inline-block cursor-pointer">
                                Upload Image
                            </label>
                            <p class="text-red-600" x-text="errors.main_image" x-show="errors.main_image"></p>
                        </div>

                        {{-- Submit --}}
                        <div class="text-right">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
                                    :disabled="submitting">
                                <span x-show="!submitting">Submit</span>
                                <span x-show="submitting">Submitting…</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('propertyForm', () => ({
                submitting: false,
                form: {
                    user_id: {{ auth()->check() ? auth()->id() : 1 }},
                    created_by: '{{ auth()->check() ? auth()->id() : 'Abdul Hadi' }}',
                    purpose: '',
                    property_type: '',
                    title: '',
                    description: '',
                    keywords: '',
                    society_id: '',
                    sub_sector_id: '',
                    block_sector: '',
                    plot_size: '',
                    instalment_plot_type: '',
                    plot_type: '',
                    street: '',
                    plot_no: '',
                    price: '',
                    rent_type: '',
                    rent: '',
                    bed_rooms: '', bath_rooms: '', garage_capacity: '',
                    drawing_rooms: '', kitchens: '', study_rooms: '',
                    store_rooms: '', servant_quarter: '', sitting_room: '',
                    hospital: '', mosque: '', banks: '', market: '',
                    restaurant: '', transportation: '', educational_institute: '',
                    public_places: '', emergency_rescue: '', fuel_stations: '',
                    instalments_downpayment: '', confirmation: '',
                    instalments_monthly_instalments: '', instalments_monthly_instalments_price: '',
                    video: '', short_video: '',
                    best_selling_property: 'N', today_deal: 'N', mail_send: 'N',
                    longitude: '', latitude: '',
                    main_image: null
                },
                errors: {},
                subsectors: [],
                blockSectors: [],
                propertyTypes: [
                    { value: 'homes', label: 'Homes' },
                    { value: 'plots', label: 'Plots' },
                    { value: 'apartments', label: 'Apartments' },
                    { value: 'shop', label: 'Shop' },
                    { value: 'farm_houses', label: 'Farm Houses' },
                    { value: 'farm_house_plots', label: 'Farm House Plots' },
                    { value: 'agriland', label: 'Agri Land' },
                ],
                houseFields: [
                    { name: 'bed_rooms', label: 'Bed Rooms', required: true },
                    { name: 'bath_rooms', label: 'Bath Rooms', required: true },
                    { name: 'garage_capacity', label: 'Garage Capacity', required: true },
                    { name: 'drawing_rooms', label: 'Drawing Rooms', required: true },
                    { name: 'kitchens', label: 'Kitchens', required: true },
                    { name: 'study_rooms', label: 'Study Rooms', required: true },
                    { name: 'store_rooms', label: 'Store Rooms', required: true },
                    { name: 'servant_quarter', label: 'Servant Quarters', required: true },
                    { name: 'sitting_room', label: 'Sitting Room-Lounge', required: true },
                    { name: 'living_room', label: 'Living Room-Lounge', required: true },
                ],
                publicFacilities: [
                    'Hospital','Mosque','Banks','Market','Restaurant',
                    'Transportation','Educational_Institute','Public_Places',
                    'Emergency_Rescue','Fuel_Stations'
                ],

                handleFileUpload(event) {
                    this.form.main_image = event.target.files[0];
                },

                async loadSubsectors() {
                    this.form.sub_sector_id = '';
                    this.form.block_sector = '';
                    this.subsectors = [];
                    this.blockSectors = [];
                    if (!this.form.society_id) return;
                    try {
                        const res = await axios.get(`/admin/properties/subsectors/${this.form.society_id}`);
                        this.subsectors = res.data || [];
                    } catch (e) {
                        this.subsectors = [];
                        showToast('Failed to load subSector-sectors.', 'error');
                    }
                },

                async loadBlocks() {
                    this.form.block_sector = '';
                    this.blockSectors = [];
                    if (!this.form.sub_sector_id) return;
                    try {
                        const res = await axios.get(`/admin/properties/blocks/${this.form.sub_sector_id}`);
                        this.blockSectors = res.data || [];
                    } catch (e) {
                        this.blockSectors = [];
                        showToast('Failed to load blocks.', 'error');
                    }
                },
                init() {
                    // Preload subsectors/blocks if editing
                    if (this.form.society_id) {
                        this.loadSubsectors().then(() => {
                            if (this.form.sub_sector_id) {
                                this.loadBlocks();
                            }
                        });
                    }
                },

                async submitForm() {
                    this.submitting = true;
                    this.errors = {};

                    const data = new FormData();
                    for (let key in this.form) {
                        data.append(key, this.form[key]);
                    }

                    try {
                        const res = await axios.post('{{ route("admin.properties.store") }}', data, {
                            headers: {'Content-Type':'multipart/form-data'}
                        });
                        showToast(res.data.message || 'Property created!', 'success');
                        setTimeout(() => window.location.reload(), 1200);
                    } catch (err) {
                        if (err.response?.data?.errors) {
                            this.errors = err.response.data.errors;
                        } else {
                            showToast('Something went wrong.', 'error');
                        }
                    } finally {
                        this.submitting = false;
                    }
                }
            }));
        });

    </script>
@endpush
