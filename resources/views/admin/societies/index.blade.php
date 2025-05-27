@extends('admin.layouts.app')

@section('title', 'View Societies - Advice Associates Real Estate Dashboard')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Societies</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-blue/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.societies.create') }}">Add New</a>
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
                    <input type="text" id="searchInput" placeholder="Society name..." class="border rounded px-3 py-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-200" id="societies-table">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-slate-800">
                            <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Society Name</th>
                            <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">City</th>
                            <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="societiesTableBody">
                        <tr><td colspan="5" class="p-4 text-center text-gray-500">Loading...</td></tr>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div id="pagination" class="mt-4 flex justify-center flex-wrap"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.getElementById('societiesTableBody');
            const paginationEl = document.getElementById('pagination');
            const perPageFilter = document.getElementById('perPageFilter');
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');

            let currentPage = 1;
            let perPage = perPageFilter.value;
            let status = '';
            let search = '';

            // Core render function
            async function fetchSocieties() {
                tableBody.innerHTML = `<tr><td colspan="5" class="p-4 text-center text-gray-500">Loading...</td></tr>`;
                try {
                    const params = {
                        page: currentPage,
                        per_page: perPage === 'all' ? 10000 : perPage,
                        status: status,
                        search: search
                    };
                    const res = await axios.get("{{ route('admin.societies.index') }}", { params });

                    const societies = res.data.data || [];
                    const meta = res.data.meta || {};
                    const links = res.data.links || [];

                    tableBody.innerHTML = '';
                    console.log(societies)
                    if (!societies.length) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-gray-500 py-6">No societies found.</td></tr>`;
                        paginationEl.innerHTML = '';
                        return;
                    }

                    societies.forEach(society => {
                        tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td class="border p-2">${society.id}</td>
                        <td class="border p-2">${society.name}</td>
                        <td class="border p-2">${society.city?.name || 'N/A'}</td>
                        <td class="border p-2 capitalize">${society.status}</td>
                        <td class="border p-2">
                            <button onclick="showSociety(${society.id})" class="text-blue-600 hover:underline mr-2">View</button>
                            <button onclick="editSociety(${society.id})" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <button onclick="deleteSociety(${society.id})" class="text-red-600 hover:underline">Delete</button>
                            ${society.deleted_at ? `<button onclick="restoreSociety(${society.id})" class="ml-2 text-green-600 hover:underline">Restore</button>` : ''}
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
                                fetchSocieties();
                            });
                        });
                    }
                } catch (err) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-red-500 py-6">Failed to load societies.</td></tr>`;
                    window.showToast('Failed to load societies.', 'error');
                }
            }

            // Filters
            perPageFilter.addEventListener('change', function () {
                perPage = this.value;
                currentPage = 1;
                fetchSocieties();
            });
            statusFilter.addEventListener('change', function () {
                status = this.value;
                currentPage = 1;
                fetchSocieties();
            });
            searchInput.addEventListener('input', function () {
                search = this.value;
                currentPage = 1;
                // Debounce for smoother UX (optional)
                if (window._searchTimeout) clearTimeout(window._searchTimeout);
                window._searchTimeout = setTimeout(fetchSocieties, 400);
            });

            // Actions (global, not in closure)
            window.showSociety = id => {
                window.location.href = "{{ route('admin.societies.view', ':id') }}".replace(':id', id);
            };
            window.editSociety = id => {
                window.location.href = "{{ route('admin.societies.edit', ':id') }}".replace(':id', id);
            };
            window.deleteSociety = async id => {
                if (!confirm('Are you sure you want to delete this society?')) return;
                try {
                    const url = "{{ route('admin.societies.remove', ':id') }}".replace(':id', id);
                    await axios.delete(url);
                    window.showToast('Society soft deleted.', 'success');
                    await fetchSocieties();
                } catch (error) {
                    window.showToast('Failed to delete society. Try again.', 'error');
                }
            };
            window.restoreSociety = async id => {
                if (!confirm('Restore this society?')) return;
                try {
                    const url = `/admin/societies/${id}/restore`;
                    await axios.post(url);
                    window.showToast('Society restored.', 'success');
                    await fetchSocieties();
                } catch (error) {
                    window.showToast('Failed to restore society.', 'error');
                }
            };

            // Initial fetch
            fetchSocieties();
        });
    </script>
@endpush
