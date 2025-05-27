@extends('admin.layouts.app')

@section('title', 'Edit City')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Edit City</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.cities.index') }}">View Cities</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Starter Page</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">

                    <!-- Loading State -->
                    <div id="city-loading" class="flex justify-center items-center py-6">
                        <svg class="animate-spin h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"/>
                        </svg>
                        <span class="ml-2 text-gray-400">Loading city details...</span>
                    </div>

                    <!-- Hidden until data is fetched -->
                    <form id="editCityForm" class="hidden">

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">City Name</label>
                            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-gray-700">Slug</label>
                            <input type="text" name="slug" id="slug" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select name="status" id="status" class="w-full border px-3 py-2 rounded">
                                <option value="enabled">Enabled</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-blue-600 text-white px-4 py-2 rounded">Update City</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate slug
        document.getElementById('name').addEventListener('input', function () {
            document.getElementById('slug').value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });
        document.addEventListener('DOMContentLoaded', function () {
            const cityId = {{ $city->id }};
            const form = document.getElementById('editCityForm');
            const loading = document.getElementById('city-loading');

            axios.get(`{{ route('admin.cities.edit', $city->id) }}`)
                .then(res => {
                    const city = res.data;
                    document.getElementById('name').value = city.name;
                    document.getElementById('slug').value = city.slug;
                    document.getElementById('status').value = city.status;

                    // Small visual delay for smoother transition
                    setTimeout(() => {
                        loading.classList.add('hidden');
                        form.classList.remove('hidden');
                    }, 300); // Adjust delay (ms) if needed
                })
                .catch(err => {
                    window.showToast('Failed to fetch city data.', 'error');
                    console.error(err);
                });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                axios.post(`/admin/cities/${cityId}`, formData, {
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                    .then(res => {
                        window.showToast(res.data.message, 'success');
                        window.location.href = '{{ route("admin.cities.index") }}';
                    })
                    .catch(err => {
                        window.showToast('Failed to update city', 'error');
                        console.error(err);
                    });
            });
        });
    </script>
@endpush
