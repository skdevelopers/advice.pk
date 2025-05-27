@extends('admin.layouts.app')

@section('title', 'Society Details')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Society Details</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block text-[16px] font-medium hover:text-green-600 text-gray-700 dark:text-white">
                        <a href="{{ route('admin.societies.index') }}">All Societies</a>
                    </li>
                </ul>
            </div>
            <div id="societyDetails" class="mt-6">
                <div class="text-center text-gray-400 py-10" id="society-loading">
                    Loading society details...
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const societyId = {{ $society->id }};
            const detailsContainer = document.getElementById('societyDetails');
            const loadingDiv = document.getElementById('society-loading');

            function safe(val, fallback = '<span class="text-gray-400 italic">Not Provided</span>') {
                if (val === undefined || val === null || (typeof val === "string" && !val.trim())) return fallback;
                return val;
            }

            axios.get("{{ route('admin.societies.view', $society->id) }}?ajax=1")
                .then(res => {
                    const data = res.data;
                    loadingDiv.style.display = 'none';

                    // Images
                    const mainImg = data.main_image_url
                        ? `<img src="${data.main_image_url}" class="h-24 w-36 object-cover rounded shadow border mb-2">`
                        : '<div class="bg-gray-100 dark:bg-slate-800 h-24 w-36 flex items-center justify-center text-gray-400 rounded border">No Image</div>';
                    const bannerImg = data.banner_url
                        ? `<img src="${data.banner_url}" class="h-24 w-36 object-cover rounded shadow border mb-2">`
                        : '<div class="bg-gray-100 dark:bg-slate-800 h-24 w-36 flex items-center justify-center text-gray-400 rounded border">No Image</div>';

                    // Property Types
                    const propTypes = (data.property_types && Object.keys(data.property_types).length)
                        ? Object.entries(data.property_types).map(([type, meta]) => `
                    <div class="border rounded p-3 bg-gray-50 dark:bg-slate-800">
                        <div class="font-semibold text-gray-700 dark:text-gray-200 mb-1">${type.replace('_', ' ').toUpperCase()}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Title: <span class="text-gray-900 dark:text-white">${safe(meta.title)}</span></div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Keywords: <span class="text-gray-900 dark:text-white">${safe(meta.keywords)}</span></div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Description: <span class="text-gray-900 dark:text-white">${safe(meta.description)}</span></div>
                    </div>
                `).join('')
                        : `<div class="text-gray-400 italic">No property types specified.</div>`;

                    // Sub Sectors
                    const subSectors = (data.sub_sectors && data.sub_sectors.length)
                        ? data.sub_sectors.map(sub => `
                    <div class="border rounded-lg p-3 bg-gray-50 dark:bg-slate-800 mb-2 shadow">
                        <div class="mb-1"><span class="font-medium">Name:</span> ${safe(sub.name)}</div>
                        <div class="mb-1"><span class="font-medium">Title:</span> ${safe(sub.title)}</div>
                        <div class="mb-1"><span class="font-medium">Slug:</span> ${safe(sub.slug)}</div>
                        <div class="mb-1"><span class="font-medium">Block:</span> ${safe(sub.block)}</div>
                        <div class="mb-1"><span class="font-medium">Detail:</span> ${safe(sub.detail)}</div>
                        <div class="mb-1">
                            ${(sub.media && sub.media.length)
                            ? sub.media.map(media => `<img src="${media.original_url}" class="h-12 inline mr-2 mb-2 rounded border shadow">`).join('')
                            : '<span class="text-xs text-gray-400">No Image</span>'
                        }
                        </div>
                    </div>
                `).join('')
                        : `<div class="text-gray-400 text-sm">No sub-sectors.</div>`;

                    let html = `
                                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg p-8 border border-slate-200 dark:border-slate-800">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                                        <div>
                                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1 flex items-center">
                                                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                                ${safe(data.society_name)}
                                            </h3>
                                            <span class="text-xs bg-blue-50 text-blue-700 rounded px-2 py-1 mr-2">Slug: ${safe(data.slug)}</span>
                                            <span class="text-xs bg-gray-100 text-gray-800 rounded px-2 py-1">Status: <span class="capitalize">${safe(data.status)}</span></span>
                                        </div>
                                        <div class="mt-4 md:mt-0 flex gap-2">
                                            <a href="{{ route('admin.societies.edit', $society->id) }}" class="btn bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700 transition">Edit</a>
                                            <a href="{{ route('admin.societies.index') }}" class="btn bg-gray-200 text-gray-800 dark:bg-slate-800 dark:text-white rounded px-4 py-2 hover:bg-gray-300 dark:hover:bg-slate-700 transition">Back</a>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                                        <!-- General Info -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-green-700 mb-2">General Information</h4>
                                            <dl class="divide-y divide-gray-200 dark:divide-slate-800">
                                                <div class="py-2 flex justify-between">
                                                    <dt class="font-medium text-gray-600 dark:text-gray-300">City</dt>
                                                    <dd class="text-gray-900 dark:text-white">${safe(data.city?.name, '<span class="text-gray-400 italic">Not Assigned</span>')}</dd>
                                                </div>
                                                <div class="py-2 flex justify-between">
                                                    <dt class="font-medium text-gray-600 dark:text-gray-300">User</dt>
                                                    <dd class="text-gray-900 dark:text-white">${safe(data.user?.name, '<span class="text-gray-400 italic">Not Assigned</span>')}</dd>
                                                </div>
                                                <div class="py-2">
                                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Overview</dt>
                                                    <dd class="text-gray-900 dark:text-gray-100 text-sm">${safe(data.overview, '<span class="text-gray-400 italic">No overview provided.</span>')}</dd>
                                                </div>
                                                <div class="py-2">
                                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Detail</dt>
                                                    <dd class="text-gray-900 dark:text-gray-100 text-sm">${safe(data.detail, '<span class="text-gray-400 italic">No detail provided.</span>')}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                        <!-- Images -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-green-700 mb-2">Images</h4>
                                            <div class="flex gap-4">
                                                <div>
                                                    <div class="text-gray-500 text-xs mb-1">Main Image</div>
                                                    ${mainImg}
                                                </div>
                                                <div>
                                                    <div class="text-gray-500 text-xs mb-1">Banner Image</div>
                                                    ${bannerImg}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Property Types -->
                                    <div class="mb-8">
                                        <h4 class="text-lg font-semibold text-green-700 mb-2">Property Types</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            ${propTypes}
                                        </div>
                                    </div>

                                    <!-- Sub Sectors -->
                                    <div>
                                        <h4 class="text-lg font-semibold text-green-700 mb-2">Sub Sectors</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            ${subSectors}
                                        </div>
                                    </div>
                                </div>
                                            `;

                    detailsContainer.innerHTML = html;
                })
                .catch(err => {
                    loadingDiv.innerText = 'Failed to load details. Try again.';
                });
        });

    </script>
@endpush
