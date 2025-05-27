@extends('admin.layouts.app')

@section('title', 'Sub-Society Details')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Sub-Society Details</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block text-[16px] font-medium hover:text-green-600 text-gray-700 dark:text-white">
                        <a href="{{ route('admin.subsocieties.index') }}">All Sub-Societies</a>
                    </li>
                </ul>
            </div>

            <!-- Details Container -->
            <div id="subsocietyDetails" class="mt-6">
                <div class="text-center text-gray-400 py-10" id="loading">
                    Loading sub-society details...
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const id = {{ $subsociety->id }};
            const container = document.getElementById('subsocietyDetails');
            const loading = document.getElementById('loading');

            function safe(val, fallback = '<span class="text-gray-400 italic">Not Provided</span>') {
                if (val === undefined || val === null) return fallback;
                if (typeof val === 'string' && !val.trim()) return fallback;
                return val;
            }

            axios.get("{{ route('admin.subsocieties.view', $subsociety->id) }}?ajax=1")
                .then(res => {
                    const d = res.data;
                    loading.style.display = 'none';

                    container.innerHTML = `
                        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg p-8 border border-slate-200 dark:border-slate-800">
                          <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                              <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1 flex items-center">
                                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                ${safe(d.name)}
                              </h3>
                              <span class="text-xs bg-blue-50 text-blue-700 rounded px-2 py-1 mr-2">
                                Slug: ${safe(d.slug)}
                              </span>
                              <span class="text-xs bg-gray-100 text-gray-800 rounded px-2 py-1">
                                Type: ${safe(d.type, '–')}
                              </span>
                            </div>
                            <div class="mt-4 md:mt-0 flex gap-2">
                              <a href="{{ route('admin.subsocieties.edit', $subsociety->id) }}"
                                 class="btn bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700 transition">
                                Edit
                              </a>
                              <a href="{{ route('admin.subsocieties.index') }}"
                                 class="btn bg-gray-200 text-gray-800 dark:bg-slate-800 dark:text-white rounded px-4 py-2 hover:bg-gray-300 dark:hover:bg-slate-700 transition">
                                Back
                              </a>
                            </div>
                          </div>

                          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                            <!-- General Info -->
                            <div>
                              <h4 class="text-lg font-semibold text-green-700 mb-2">General Information</h4>
                              <dl class="divide-y divide-gray-200 dark:divide-slate-800">
                                <div class="py-2 flex justify-between">
                                  <dt class="font-medium text-gray-600 dark:text-gray-300">ID</dt>
                                  <dd class="text-gray-900 dark:text-white">${d.id}</dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                  <dt class="font-medium text-gray-600 dark:text-gray-300">Society</dt>
                                  <dd class="text-gray-900 dark:text-white">
                                    ${safe(d.society?.society_name)}
                                  </dd>
                                </div>
                                <div class="py-2">
                                  <dt class="font-medium text-gray-600 dark:text-gray-300 mb-1">Detail</dt>
                                  <dd class="text-gray-900 dark:text-gray-100 text-sm">
                                    ${safe(d.detail, '<span class="text-gray-400 italic">No detail provided.</span>')}
                                  </dd>
                                </div>
                              </dl>
                            </div>
                          </div>
                        </div>`;
                })
                .catch(() => {
                    loading.innerText = 'Failed to load details. Try again.';
                    showToast('Unable to fetch details','error');
                });
        });
    </script>
@endpush
