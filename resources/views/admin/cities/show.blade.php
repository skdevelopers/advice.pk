@extends('admin.layouts.app')

@section('title', 'City Details')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">City Details</h5>
                <a href="{{ route('admin.cities.index') }}" class="btn bg-gray-200 dark:bg-slate-800 dark:text-white px-4 py-2 rounded hover:bg-gray-300 dark:hover:bg-slate-700">
                    Back to All Cities
                </a>
            </div>
            <div id="cityDetails" class="mt-6">
                <div class="text-center text-gray-400 py-10" id="city-loading">
                    Loading city details...
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cityId = {{ $city->id }};
            const detailsContainer = document.getElementById('cityDetails');
            const loadingDiv = document.getElementById('city-loading');

            function safe(val, fallback = '<span class="text-gray-400 italic">Not Provided</span>') {
                if (val === undefined || val === null || (typeof val === "string" && !val.trim())) return fallback;
                return val;
            }

            axios.get(`/admin/cities/${cityId}?ajax=1`)
                .then(res => {
                    const data = res.data;
                    loadingDiv.style.display = 'none';

                    detailsContainer.innerHTML = `
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 border border-slate-200 dark:border-slate-800">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">${safe(data.name)}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Slug:</div>
                                <div class="text-base text-gray-900 dark:text-white font-medium">${safe(data.slug)}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Status:</div>
                                <div class="text-base font-medium capitalize ${data.status === 'enabled' ? 'text-green-600' : 'text-red-600'}">
                                    ${safe(data.status)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                })
                .catch(err => {
                    loadingDiv.innerText = 'Failed to load city details.';
                    console.error(err);
                });
        });
    </script>
@endpush
