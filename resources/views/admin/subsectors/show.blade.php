@extends('admin.layouts.app')

@section('title', 'Sub-Sector Details')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Sub-Sector Details</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block text-[16px] font-medium hover:text-green-600 text-gray-700 dark:text-green">
                        <a href="{{ route('admin.subsectors.index') }}">All Sub-Sectors</a>
                    </li>
                </ul>
            </div>

            <div id="subSectorDetails" class="mt-6">
                <div class="text-center text-gray-400 py-10" id="subSector-loading">
                    Loading...
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const id              = {{ $subSector->id }};
            const container       = document.getElementById('subSectorDetails');
            const loadingDiv      = document.getElementById('subSector-loading');

            function safe(val, fallback = '<span class="text-gray-400 italic">Not Provided</span>') {
                if (val === undefined || val === null) return fallback;
                if (typeof val === 'string' && ! val.trim()) return fallback;
                return val;
            }

            axios.get("{{ route('admin.subsectors.show', $subSector->id) }}?ajax=1")
                .then(res => {
                    const d = res.data;
                    loadingDiv.style.display = 'none';

                    // Parent
                    const parentName = safe(d.parent?.name, '<span class="text-green-600 dark:text-gray-300">None</span>');

                    // Children
                    const childrenHtml = (d.children && d.children.length)
                        ? d.children.map(c => `
                    <div class="border rounded p-3 bg-gray-50 dark:bg-slate-800 mb-2">
                        <div><span class="font-medium">Name:</span> ${ safe(c.name) }</div>
                        <div><span class="font-medium">Slug:</span> ${ safe(c.slug) }</div>
                        <div><span class="font-medium">Block:</span> ${ safe(c.block) }</div>
                    </div>
                `).join('')
                        : '<div class="text-green-600 dark:text-gray-300">No child sub-sectors.</div>';

                    // Image
                    const imageHtml = (d.media && d.media.length)
                        ? d.media.map(m => `<img src="${m.original_url}" class="h-24 w-36 object-cover rounded shadow border mr-2 mb-2">`).join('')
                        : '<div class="bg-gray-100 dark:bg-slate-800 h-24 w-36 flex items-center justify-center text-gray-400 rounded border">No Image</div>';

                    const html = `
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg p-8 border border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-green mb-1">
                                ${ safe(d.name) }
                            </h3>
                            <span class="text-xs bg-blue-50 text-blue-700 rounded px-2 py-1 mr-2">
                                Slug: ${ safe(d.slug) }
                            </span>
                            <span class="text-xs bg-gray-100 text-gray-800 rounded px-2 py-1">
                                Block: ${ safe(d.block) }
                            </span>
                        </div>
                        <div class="mt-4 md:mt-0 flex gap-2">
                            <a href="{{ route('admin.subsectors.edit', $subSector->id) }}"
                               class="btn bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700 transition">
                                Edit
                            </a>
                            <a href="{{ route('admin.subsectors.index') }}"
                               class="btn bg-gray-200 text-gray-800 dark:bg-slate-800 dark:text-white rounded px-4 py-2 hover:bg-gray-300 dark:hover:bg-slate-700 transition">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                        <!-- Basics -->
                        <div>
                            <h4 class="text-lg font-semibold text-green-700 mb-2">Details</h4>
                            <dl class="divide-y divide-gray-200 dark:divide-slate-800">
                                <div class="py-2 flex justify-between">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300">Society</dt>
                                    <dd class="text-green-600 dark:text-gray-300">
                                        ${ safe(d.society?.name) }
                                    </dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300">Parent</dt>
                                    <dd class="text-green-600 dark:text-gray-300">${ parentName }</dd>
                                </div>
                                <div class="py-2">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Title</dt>
                                    <dd class="text-green-600 dark:text-gray-100 text-sm">
                                        ${ safe(d.title) }
                                    </dd>
                                </div>
                                <div class="py-2">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Meta Keywords</dt>
                                    <dd class="text-green-600 dark:text-gray-100 text-sm">
                                        ${ safe(d.meta_keywords) }
                                    </dd>
                                </div>
                                <div class="py-2">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Meta Detail</dt>
                                    <dd class="text-green-600 dark:text-gray-100 text-sm">
                                        ${ safe(d.meta_detail) }
                                    </dd>
                                </div>
                                <div class="py-2">
                                    <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Detail</dt>
                                    <dd class="text-green-600 dark:text-gray-100 text-sm">
                                        ${ safe(d.detail) }
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <!-- Image -->
                        <div>
                            <h4 class="text-lg font-semibold text-green-700 mb-2">Image</h4>
                            ${ imageHtml }
                        </div>
                    </div>

                    <!-- Children -->
                    <div>
                        <h4 class="text-lg font-semibold text-green-700 mb-2">Child Sub-Sectors</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${ childrenHtml }
                        </div>
                    </div>
                </div>
            `;

                    container.innerHTML = html;
                })
                .catch(err => {
                    loadingDiv.innerText = 'Failed to load details. Please try again.';
                });
        });
    </script>
@endpush
