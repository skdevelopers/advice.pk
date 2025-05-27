@extends('admin.layouts.app')

@section('title', 'View Sub Societies - Advice Associates Real Estate Dashboard')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">subsocieties</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-blue/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.subsocieties.create') }}">Add New</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white"
                        aria-current="page">View
                    </li>
                </ul>
            </div>

            <!-- Filters -->
            <div class="mt-4 flex flex-wrap items-center space-x-4">
                <div>
                    <label class="block text-sm font-medium">Records per page</label>
                    <select id="perPageFilter" class="border rounded px-3 py-2">
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="250">250</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select id="statusFilter" class="border rounded px-3 py-2">
                        <option value="">All</option>
                        <option value="enabled">Enabled</option>
                        <option value="disabled">Disabled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Search</label>
                    <input type="text" id="searchInput" placeholder="Sub-society name..." class="border rounded px-3 py-2" />
                </div>
            </div>

            <!-- Table -->
            <div class="mt-6 bg-white dark:bg-slate-900 rounded shadow p-6 overflow-auto">
                <table class="w-full table-auto border-collapse text-sm">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-slate-800">
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">ID</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Slug</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Type</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600r">Society</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="list">
                    <tr><td colspan="6" class="p-4 text-center text-gray-500">Loading…</td></tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div id="pagination" class="mt-4 flex justify-center"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('list');
            const paginationEl = document.getElementById('pagination');
            const perPageFilter = document.getElementById('perPageFilter');
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');

            let currentPage = 1;
            let perPage = perPageFilter.value;
            let status = '';
            let search = '';

            // Core render function
            async function fetchList() {
                tableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-gray-500">Loading subsocieties...</td></tr>`;
                try {
                    const params = {
                        page: currentPage,
                        per_page: perPage === 'all' ? 10000 : perPage,
                        status: status,
                        search: search
                    };
                    const res = await axios.get("{{ route('admin.subsocieties.index') }}", { params });
                    const subs = res.data.data || [];
                    const meta = res.data.meta || {};
                    const links = res.data.links || [];

                    tableBody.innerHTML = '';
                    if (!subs.length) {
                        tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-gray-500 py-6">No subsocieties found.</td></tr>`;
                        paginationEl.innerHTML = '';
                        return;
                    }

                    subs.forEach(sub => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td class="border p-2">${sub.id}</td>
                                <td class="border p-2">${sub.name}</td>
                                <td class="border p-2">${sub.slug}</td>
                                <td class="border p-2">${sub.type || '-'}</td>
                                <td class="border p-2">${sub.society.name || 'N/A'}</td>
                                <td class="border p-2 capitalize">${sub.status}</td>
                                <td class="border p-2">
                                    <button onclick="showSubSociety(${sub.id})" class="text-blue-600 hover:underline mr-2">View</button>
                                    <button onclick="editSubSociety(${sub.id})" class="text-blue-600 hover:underline mr-2">Edit</button>
                                    <button onclick="deleteSubSociety(${sub.id})" class="text-red-600 hover:underline">Delete</button>
                                    ${sub.deleted_at ? `<button onclick="restoreSubSociety(${sub.id})" class="ml-2 text-green-600 hover:underline">Restore</button>` : ''}
                                </td>
                            </tr>
                        `);
                    });

                    // Pagination
                    paginationEl.innerHTML = '';
                    if (links && links.length > 0) {
                        links.forEach(link => {
                            if (link.url) {
                                paginationEl.insertAdjacentHTML('beforeend', `
                                    <button data-url="${link.url}"
                                            class="mx-1 mb-2 px-3 py-1 border rounded ${link.active ? 'bg-green-600 text-white' : 'bg-white text-gray-800'}">
                                        ${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}
                                    </button>
                                `);
                            }
                        });

                        document.querySelectorAll('#pagination button').forEach(btn => {
                            btn.addEventListener('click', e => {
                                e.preventDefault();
                                const url = new URL(btn.dataset.url, window.location.origin);
                                currentPage = url.searchParams.get('page') || 1;
                                fetchList();
                            });
                        });
                    }
                } catch (err) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-red-500 py-6">Failed to load subsocieties.</td></tr>`;
                    window.showToast('Failed to load subsocieties.', 'error');
                }
            }

            // Filters
            perPageFilter.addEventListener('change', function () {
                perPage = this.value;
                currentPage = 1;
                fetchList();
            });
            statusFilter.addEventListener('change', function () {
                status = this.value;
                currentPage = 1;
                fetchList();
            });
            searchInput.addEventListener('input', function () {
                search = this.value;
                currentPage = 1;
                // Debounce for smoother UX (optional)
                if (window._searchTimeout) clearTimeout(window._searchTimeout);
                window._searchTimeout = setTimeout(fetchList, 400);
            });

            // Actions (global, not in closure)
            window.showSubSociety = id => {
                window.location.href = "{{ route('admin.subsocieties.view', ':id') }}".replace(':id', id);
            };
            window.editSubSociety = id => {
                window.location.href = "{{ route('admin.subsocieties.edit', ':id') }}".replace(':id', id);
            };
            window.deleteSubSociety = async id => {
                if (!confirm('Are you sure you want to delete this sub-society?')) return;
                try {
                    const url = "{{ route('admin.subsocieties.remove', ':id') }}".replace(':id', id);
                    await axios.delete(url);
                    window.showToast('Subsociety soft deleted.', 'success');
                    await fetchList();
                } catch (error) {
                    window.showToast('Failed to delete subsociety. Try again.', 'error');
                }
            };
            window.restoreSubSociety = async id => {
                if (!confirm('Restore this society?')) return;
                try {
                    const url = `/admin/subsocieties/${id}/restore`;
                    await axios.post(url);
                    window.showToast('Society restored.', 'success');
                    await fetchList();
                } catch (error) {
                    window.showToast('Failed to restore society.', 'error');
                }
            };
            // Initial fetch
            fetchList();
        });
    </script>
@endpush
