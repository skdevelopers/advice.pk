@extends('admin.layouts.app')

@section('title', 'Cities List')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">

            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Cities</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium hover:text-green-600">
                        <a href="{{ route('admin.cities.create') }}">Add New</a>
                    </li>
                    <li class="inline-block mx-1 text-slate-500"><i class="mdi mdi-chevron-right"></i></li>
                    <li class="inline-block text-[16px] font-medium text-green-600">Cities</li>
                </ul>
            </div>

            <!-- Filters -->
            <div>
                <label class="block text-sm font-medium">Records per page</label>
                <select id="perPageFilter" class="border rounded px-3 py-2">
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="all">All</option>
                </select>
            </div>

            <!-- Table -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm p-6 bg-white dark:bg-slate-900 overflow-x-auto">
                    <table class="w-full table-auto border-collapse text-sm">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-slate-800 text-left">
                            <th class="p-2 border cursor-pointer" data-sort="id">ID <span></span></th>
                            <th class="p-2 border cursor-pointer" data-sort="name">Name <span></span></th>
                            <th class="p-2 border cursor-pointer" data-sort="slug">Slug <span></span></th>
                            <th class="p-2 border cursor-pointer" data-sort="status">Status <span></span></th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="cityTableBody">
                        <tr><td colspan="5" class="p-4 text-center text-gray-500">Loading cities...</td></tr>
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
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('cityTableBody');
            const paginationEl = document.getElementById('pagination');
            const perPageFilter = document.getElementById('perPageFilter');

            let currentPage = 1, sortField = 'id', sortDir = 'asc', perPage = 50;

            function showToast(msg, type = 'info') {
                window.showToast(msg, type);
            }

            function updateSortIcons() {
                document.querySelectorAll('th[data-sort]').forEach(th => {
                    const span = th.querySelector('span');
                    if (th.dataset.sort === sortField) {
                        span.textContent = sortDir === 'asc' ? ' ▲' : ' ▼';
                    } else {
                        span.textContent = '';
                    }
                });
            }

            async function fetchCities() {
                try {
                    let params = {
                        sort: sortField,
                        order: sortDir,
                    };

                    // "all" means don't send page or per_page, backend will send all results
                    if (perPage !== 'all') {
                        params.page = currentPage;
                        params.per_page = perPage;
                    } else {
                        params.per_page = 'all'; // so backend can handle this
                    }

                    const res = await axios.get("{{ route('admin.cities.index') }}", { params });
                    const cities = res.data.data || [];
                    const links = res.data.links || [];

                    tableBody.innerHTML = '';
                    paginationEl.innerHTML = '';

                    if (!cities.length) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-gray-500 py-6">No cities found.</td></tr>`;
                        return;
                    }

                    cities.forEach(city => {
                        tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td class="border p-2">${city.id}</td>
                        <td class="border p-2">${city.name}</td>
                        <td class="border p-2">${city.slug}</td>
                        <td class="border p-2 capitalize">${city.status}</td>
                        <td class="border p-2">
                            <button onclick="editCity(${city.id})" class="text-blue-600 hover:underline mr-2">Edit</button>
                            <button onclick="deleteCity(${city.id})" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                `);
                    });

                    // Show pagination only if not "all"
                    if (perPage !== 'all') {
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
                                currentPage = new URL(btn.dataset.url).searchParams.get('page') || 1;
                                fetchCities();
                            });
                        });
                    } else {
                        paginationEl.innerHTML = ''; // Hide pagination when all
                    }

                    updateSortIcons();
                } catch (err) {
                    console.error(err);
                    showToast('Failed to load cities.', 'error');
                }
            }

            document.querySelectorAll('th[data-sort]').forEach(th => {
                th.addEventListener('click', () => {
                    const field = th.dataset.sort;
                    if (sortField === field) {
                        sortDir = sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortField = field;
                        sortDir = 'asc';
                    }
                    currentPage = 1;
                    fetchCities();
                });
            });

            perPageFilter.addEventListener('change', () => {
                perPage = perPageFilter.value;
                currentPage = 1;
                fetchCities();
            });

            window.editCity = id => {
                window.location.href = "{{ route('admin.cities.edit', ':id') }}".replace(':id', id);
            };

            window.deleteCity = async id => {
                if (!confirm('Are you sure you want to delete this city?')) return;
                try {
                    const url = "{{ route('admin.cities.remove', ':id') }}".replace(':id', id);
                    const res = await axios.delete(url);
                    showToast(res.data.message || 'City deleted successfully.', 'success');
                    fetchCities();
                } catch (error) {
                    showToast('Delete failed. Try again.', 'error');
                }
            };

            fetchCities();
        });

    </script>
@endpush
