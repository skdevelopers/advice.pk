@extends('admin.layouts.app')

@section('title', 'View Sub-Sectors - Advice Associates Real Estate AI Dashboard')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Header & New Button -->
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Sub-Sectors</h5>
                <a href="{{ route('admin.subsectors.create') }}"
                   class="text-green-600 hover:underline">Add New Sub-Sector</a>
            </div>

            <!-- Filters -->
            <div class="mt-4 flex flex-wrap items-end gap-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Records per page</label>
                    <select id="perPageFilter" class="border rounded px-3 py-2">
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="250">250</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select id="statusFilter" class="border rounded px-3 py-2">
                        <option value="">All</option>
                        <option value="enabled">Enabled</option>
                        <option value="disabled">Disabled</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Search by name</label>
                    <input
                            type="text"
                            id="searchInput"
                            placeholder="Enter subSector-sector name..."
                            class="w-full border rounded px-3 py-2"
                    >
                </div>
            </div>

            <!-- Table -->
            <div class="mt-6 bg-white dark:bg-slate-900 rounded shadow p-6 overflow-auto">
                <table class="w-full table-auto border-collapse text-sm">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-slate-800">
                        <th class="px-4 py-2 border-b text-left font-semibold">ID</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Name</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Slug</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Type</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Society</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Status</th>
                        <th class="px-4 py-2 border-b text-left font-semibold">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="list">
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Loading…</td>
                    </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div id="pagination" class="mt-4 flex justify-center gap-2"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const listEl        = document.getElementById('list');
            const paginationEl  = document.getElementById('pagination');
            const perPageFilter = document.getElementById('perPageFilter');
            const statusFilter  = document.getElementById('statusFilter');
            const searchInput   = document.getElementById('searchInput');

            let currentPage = 1;
            let perPage     = perPageFilter.value;
            let status      = '';
            let search      = '';

            async function fetchSubSectors() {
                listEl.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-gray-500">Loading subSector-sectors…</td></tr>`;
                try {
                    const params = {
                        page:      currentPage,
                        per_page:  perPage === 'all' ? 10000 : perPage,
                        status,
                        search,
                        ajax:      1
                    };
                    const res = await axios.get("{{ route('admin.subsectors.index') }}", { params });
                    const items = res.data.data || [];
                    const links = res.data.links || [];
                    renderTable(items);
                    renderPagination(links);
                } catch (err) {
                    listEl.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-red-500">Failed to load subSector-sectors.</td></tr>`;
                    window.showToast('Failed to fetch subSector-sectors.', 'error');
                }
            }

            function renderTable(items) {
                if (items.length === 0) {
                    listEl.innerHTML = `<tr><td colspan="7" class="p-4 text-center text-gray-500">No subSector-sectors found.</td></tr>`;
                    paginationEl.innerHTML = '';
                    return;
                }
                listEl.innerHTML = '';
                items.forEach(s => {
                    listEl.insertAdjacentHTML('beforeend', `
                <tr>
                    <td class="border px-4 py-2">${s.id}</td>
                    <td class="border px-4 py-2">${s.name}</td>
                    <td class="border px-4 py-2">${s.slug}</td>
                    <td class="border px-4 py-2">${s.type || '—'}</td>
                    <td class="border px-4 py-2">${s.society?.name || '—'}</td>
                    <td class="border px-4 py-2 capitalize">${s.status}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button onclick="location.href='{{ route('admin.subsectors.show','__id__') }}'.replace('__id__',${s.id})"
                                class="text-blue-600 hover:underline">View</button>
                        <button onclick="location.href='{{ route('admin.subsectors.edit','__id__') }}'.replace('__id__',${s.id})"
                                class="text-blue-600 hover:underline">Edit</button>
                        <button onclick="deleteSub(${s.id})" class="text-red-600 hover:underline">Delete</button>
                        ${s.deleted_at
                        ? `<button onclick="restoreSub(${s.id})" class="ml-2 text-green-600 hover:underline">Restore</button>`
                        : ''
                    }
                    </td>
                </tr>
            `);
                });
            }

            function renderPagination(links) {
                paginationEl.innerHTML = '';
                if (!Array.isArray(links) || links.length === 0) {
                    return;
                }
                links.forEach(link => {
                    if (!link.url) return;
                    const btnHtml = `
                <button
                  data-url="${link.url}"
                  class="px-3 py-1 border rounded ${link.active ? 'bg-green-600 text-white' : 'bg-white text-gray-800'}"
                >
                  ${link.label.replace(/&laquo;/g,'«').replace(/&raquo;/g,'»')}
                </button>
            `;
                    paginationEl.insertAdjacentHTML('beforeend', btnHtml);
                });
                paginationEl.querySelectorAll('button[data-url]').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        const url = new URL(btn.dataset.url, window.location.origin);
                        currentPage = url.searchParams.get('page') || 1;
                        fetchSubSectors();
                    });
                });
            }

            perPageFilter.addEventListener('change', () => {
                perPage = perPageFilter.value;
                currentPage = 1;
                fetchSubSectors();
            });
            statusFilter.addEventListener('change', () => {
                status = statusFilter.value;
                currentPage = 1;
                fetchSubSectors();
            });
            searchInput.addEventListener('input', () => {
                search = searchInput.value;
                currentPage = 1;
                clearTimeout(window._subSearchDebounce);
                window._subSearchDebounce = setTimeout(fetchSubSectors, 300);
            });

            window.deleteSub = async id => {
                if (!confirm('Delete this subSector-sector?')) return;
                try {
                    await axios.delete(`{{ url('admin/subsectors') }}/${id}`);
                    window.showToast('Deleted.', 'success');
                    fetchSubSectors();
                } catch {
                    window.showToast('Deletion failed.', 'error');
                }
            };

            window.restoreSub = async id => {
                if (!confirm('Restore this subSector-sector?')) return;
                try {
                    await axios.post(`{{ url('admin/subsectors') }}/${id}/restore`);
                    window.showToast('Restored.', 'success');
                    fetchSubSectors();
                } catch {
                    window.showToast('Restore failed.', 'error');
                }
            };

            // first load
            fetchSubSectors();
        });
    </script>
@endpush


