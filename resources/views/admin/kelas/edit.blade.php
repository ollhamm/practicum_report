<x-app-layout>
    <div class="py-6">
        <div class="px-2 mb-4">
            <ol class="flex w-full flex-wrap items-center">
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex active items-center text-sm text-gray-500 transition-colors duration-300 ">
                    <span>Kelas</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/kelas">Manajemen Kelas</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Edit Data Kelas</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Data Kelas</h2>
                        <a href="{{ route('admin.kelas.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>


                    <form action="{{ route('admin.kelas.update', $kela) }}" method="POST" class="space-y-6" id="kelasForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kelas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kela->nama_kelas) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('nama_kelas') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan nama kelas">
                                @error('nama_kelas')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Kelas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode" id="kode" value="{{ old('kode', $kela->kode) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('kode') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan kode kelas">
                                @error('kode')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', $kela->tahun_ajaran) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('tahun_ajaran') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="2023/2024">
                                @error('tahun_ajaran')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select name="semester" id="semester" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('semester') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Semester</option>
                                    <option value="ganjil" {{ old('semester', $kela->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="genap" {{ old('semester', $kela->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Angkatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan', $kela->angkatan) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('angkatan') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="2023">
                                @error('angkatan')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Pengaturan Kelas</h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Dosen Pengajar <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center justify-between p-3 border border-gray-300 rounded-sm bg-gray-50">
                                        <div>
                                            <span id="selectedDosenCount" class="text-sm text-gray-600">{{ count($selectedDosen) }} dosen dipilih</span>
                                            <div id="selectedDosenList" class="mt-1 text-xs text-gray-500">
                                                @foreach($dosen->whereIn('id', $selectedDosen) as $d)
                                                <div>{{ $d->name }} ({{ $d->nip }})</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="button" id="openDosenModal"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-sm hover:bg-blue-600 transition-all duration-300 cursor-pointer text-sm">
                                            <i class="fas fa-users mr-2"></i>Pilih Dosen
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Mahasiswa <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center justify-between p-3 border border-gray-300 rounded-sm bg-gray-50">
                                        <div>
                                            <span id="selectedMahasiswaCount" class="text-sm text-gray-600">{{ count($selectedMahasiswa) }} mahasiswa dipilih</span>
                                            <div id="selectedMahasiswaList" class="mt-1 text-xs text-gray-500">
                                                @foreach($mahasiswa->whereIn('id', $selectedMahasiswa) as $m)
                                                <div>{{ $m->name }} ({{ $m->nip }})</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="button" id="openMahasiswaModal"
                                            class="px-4 py-2 bg-green-500 text-white rounded-sm hover:bg-green-600 transition-all cursor-pointer duration-300 text-sm">
                                            <i class="fas fa-user-graduate mr-2"></i>Pilih Mahasiswa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="hiddenInputs">
                            @foreach($selectedDosen as $dosenId)
                            <input type="hidden" name="dosen_ids[]" value="{{ $dosenId }}">
                            @endforeach
                            @foreach($selectedMahasiswa as $mahasiswaId)
                            <input type="hidden" name="mahasiswa_ids[]" value="{{ $mahasiswaId }}">
                            @endforeach
                        </div>

                        <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    <div id="hiddenInputs"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedDosenContainer = document.getElementById('selectedDosenContainer');
            const selectedMahasiswaContainer = document.getElementById('selectedMahasiswaContainer');
            const form = document.getElementById('kelasForm');

            // Hidden inputs for storing selected IDs
            const dosenIdsInput = document.createElement('input');
            dosenIdsInput.type = 'hidden';
            dosenIdsInput.name = 'dosen_ids[]';
            form.appendChild(dosenIdsInput);

            const mahasiswaIdsInput = document.createElement('input');
            mahasiswaIdsInput.type = 'hidden';
            mahasiswaIdsInput.name = 'mahasiswa_ids[]';
            form.appendChild(mahasiswaIdsInput);

            // Listen for dosen selection events
            window.addEventListener('users-selected', function(event) {
                if (event.detail.role === 'dosen') {
                    dosenIdsInput.value = event.detail.users.join(',');
                    updateSelectedUsers(event.detail.users, event.detail.names, selectedDosenContainer);
                } else if (event.detail.role === 'mahasiswa') {
                    mahasiswaIdsInput.value = event.detail.users.join(',');
                    updateSelectedUsers(event.detail.users, event.detail.names, selectedMahasiswaContainer);
                }
            });

            function updateSelectedUsers(ids, names, container) {
                container.innerHTML = '';
                names.forEach(name => {
                    const tag = document.createElement('div');
                    tag.className = 'inline-flex items-center bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-sm';
                    tag.textContent = name;
                    container.appendChild(tag);
                });
            }
        });
    </script>
    @endpush

    <script>
        // Data dari controller - akan diisi melalui Blade template
        let dosenData = @json($dosen ?? []);
        let mahasiswaData = @json($mahasiswa ?? []);

        // Untuk edit mode, data yang sudah dipilih sebelumnya dari database
        let preSelectedDosen = @json($selectedDosen ?? []);
        let preSelectedMahasiswa = @json($selectedMahasiswa ?? []);

        // Untuk edit mode, data kelas yang sedang diedit
        let kelasData = @json($kelas ?? null);
        let currentKelasDosen = @json($kelasDosen ?? []);
        let currentKelasMahasiswa = @json($kelasMahasiswa ?? []);

        // Initialize selected arrays dengan data existing
        let selectedDosen = [];
        let selectedMahasiswa = [];

        // Jika mode edit, ambil data dari relasi kelas
        if (kelasData && kelasData.id) {
            // Mengambil ID dosen yang sudah terdaftar di kelas ini
            selectedDosen = currentKelasDosen.map(item => item.dosen_id || item.id);
            selectedMahasiswa = currentKelasMahasiswa.map(item => item.mahasiswa_id || item.id);
        } else {
            // Jika mode create, gunakan preselected data
            selectedDosen = [...preSelectedDosen];
            selectedMahasiswa = [...preSelectedMahasiswa];
        }

        let dosenTable, mahasiswaTable;

        $(document).ready(function() {
            // Initialize DataTables
            initializeDosenTable();
            initializeMahasiswaTable();

            // Update initial display for edit mode
            if (selectedDosen.length > 0 || selectedMahasiswa.length > 0) {
                updateSelectedDosenDisplay();
                updateSelectedMahasiswaDisplay();
                updateHiddenInputs();
            }

            // Jika mode edit, load existing data
            if (kelasData && kelasData.id) {
                loadExistingKelasData();
            }

            // Modal events
            $('#openDosenModal').click(function() {
                $('#dosenModal').removeClass('hidden');
                updateDosenSelection();
            });

            $('#openMahasiswaModal').click(function() {
                $('#mahasiswaModal').removeClass('hidden');
                updateMahasiswaSelection();
            });

            $('#closeDosenModal, #cancelDosenSelection').click(function() {
                $('#dosenModal').addClass('hidden');
            });

            $('#closeMahasiswaModal, #cancelMahasiswaSelection').click(function() {
                $('#mahasiswaModal').addClass('hidden');
            });

            // Confirm selections
            $('#confirmDosenSelection').click(function() {
                updateSelectedDosenDisplay();
                updateHiddenInputs();
                $('#dosenModal').addClass('hidden');
            });

            $('#confirmMahasiswaSelection').click(function() {
                updateSelectedMahasiswaDisplay();
                updateHiddenInputs();
                $('#mahasiswaModal').addClass('hidden');
            });

            // Select all checkboxes
            $('#selectAllDosen').change(function() {
                const isChecked = $(this).is(':checked');
                $('#dosenTable tbody input[type="checkbox"]').prop('checked', isChecked);
                updateDosenSelection();
            });

            $('#selectAllMahasiswa').change(function() {
                const isChecked = $(this).is(':checked');
                $('#mahasiswaTable tbody input[type="checkbox"]').prop('checked', isChecked);
                updateMahasiswaSelection();
            });
        });

        // Function untuk load data existing kelas
        function loadExistingKelasData() {
            // Populate form fields dengan data kelas yang sedang diedit
            if (kelasData) {
                $('#nama_kelas').val(kelasData.nama_kelas || '');
                $('#kode_kelas').val(kelasData.kode_kelas || '');
                $('#deskripsi').val(kelasData.deskripsi || '');
                $('#tahun_ajaran').val(kelasData.tahun_ajaran || '');
                $('#semester').val(kelasData.semester || '');
                $('#status').val(kelasData.status || 'aktif');
            }

            // Update display untuk selected users
            updateSelectedDosenDisplay();
            updateSelectedMahasiswaDisplay();
            updateHiddenInputs();

            // Refresh tabel untuk menampilkan checkbox yang sudah tercentang
            if (dosenTable) {
                dosenTable.draw();
            }
            if (mahasiswaTable) {
                mahasiswaTable.draw();
            }
        }

        function initializeDosenTable() {
            $("#customSearchDosen").on("keyup", function() {
                dosenTable.search(this.value).draw();
            });

            dosenTable = $('#dosenTable').DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                order: [
                    [0, "dsc"]
                ],
                data: dosenData,
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            const checked = selectedDosen.includes(row.id) ? 'checked' : '';
                            return `<input type="checkbox" class="dosen-checkbox rounded" data-id="${row.id}" ${checked}>`;
                        },
                        orderable: false
                    },
                    {
                        data: 'name',
                        title: 'Nama'
                    },
                    {
                        data: 'nip',
                        title: 'NIP',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                ],
                drawCallback: function() {
                    // Re-apply selections after table redraw
                    selectedDosen.forEach(id => {
                        $(`#dosenTable input[data-id="${id}"]`).prop('checked', true);
                    });
                }
            });

            // Handle individual checkbox changes
            $('#dosenTable tbody').on('change', 'input[type="checkbox"]', function() {
                updateDosenSelection();
            });
        }

        function initializeMahasiswaTable() {
            $("#customSearchMahasiswa").on("keyup", function() {
                mahasiswaTable.search(this.value).draw();
            });

            mahasiswaTable = $('#mahasiswaTable').DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                order: [
                    [0, "dsc"]
                ],
                data: mahasiswaData,
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            const checked = selectedMahasiswa.includes(row.id) ? 'checked' : '';
                            return `<input type="checkbox" class="mahasiswa-checkbox rounded" data-id="${row.id}" ${checked}>`;
                        },
                        orderable: false
                    },
                    {
                        data: 'name',
                        title: 'Nama'
                    },
                    {
                        data: 'nip',
                        title: 'NIM',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                ],
                drawCallback: function() {
                    // Re-apply selections after table redraw
                    selectedMahasiswa.forEach(id => {
                        $(`#mahasiswaTable input[data-id="${id}"]`).prop('checked', true);
                    });
                }
            });

            // Handle individual checkbox changes
            $('#mahasiswaTable tbody').on('change', 'input[type="checkbox"]', function() {
                updateMahasiswaSelection();
            });
        }

        function updateDosenSelection() {
            let tempSelectedDosen = [...selectedDosen];
            $('#dosenTable tbody input[type="checkbox"]').each(function() {
                const id = parseInt($(this).data('id'));
                if ($(this).is(':checked')) {
                    if (!tempSelectedDosen.includes(id)) {
                        tempSelectedDosen.push(id);
                    }
                } else {
                    tempSelectedDosen = tempSelectedDosen.filter(item => item !== id);
                }
            });
            selectedDosen = tempSelectedDosen;

            $('#dosenSelectionInfo').text(`${selectedDosen.length} dosen dipilih`);
            $('#dosenSelectedCount').text(selectedDosen.length);

            // Update select all checkbox state
            const totalCheckboxes = $('#dosenTable tbody input[type="checkbox"]').length;
            const checkedCheckboxes = $('#dosenTable tbody input[type="checkbox"]:checked').length;

            if (checkedCheckboxes === 0) {
                $('#selectAllDosen').prop('indeterminate', false).prop('checked', false);
            } else if (checkedCheckboxes === totalCheckboxes) {
                $('#selectAllDosen').prop('indeterminate', false).prop('checked', true);
            } else {
                $('#selectAllDosen').prop('indeterminate', true);
            }
        }

        function updateMahasiswaSelection() {
            let tempSelectedMahasiswa = [...selectedMahasiswa];
            $('#mahasiswaTable tbody input[type="checkbox"]').each(function() {
                const id = parseInt($(this).data('id'));
                if ($(this).is(':checked')) {
                    if (!tempSelectedMahasiswa.includes(id)) {
                        tempSelectedMahasiswa.push(id);
                    }
                } else {
                    tempSelectedMahasiswa = tempSelectedMahasiswa.filter(item => item !== id);
                }
            });
            selectedMahasiswa = tempSelectedMahasiswa;

            $('#mahasiswaSelectionInfo').text(`${selectedMahasiswa.length} mahasiswa dipilih`);
            $('#mahasiswaSelectedCount').text(selectedMahasiswa.length);

            // Update select all checkbox state
            const totalCheckboxes = $('#mahasiswaTable tbody input[type="checkbox"]').length;
            const checkedCheckboxes = $('#mahasiswaTable tbody input[type="checkbox"]:checked').length;

            if (checkedCheckboxes === 0) {
                $('#selectAllMahasiswa').prop('indeterminate', false).prop('checked', false);
            } else if (checkedCheckboxes === totalCheckboxes) {
                $('#selectAllMahasiswa').prop('indeterminate', false).prop('checked', true);
            } else {
                $('#selectAllMahasiswa').prop('indeterminate', true);
            }
        }

        function updateSelectedDosenDisplay() {
            const count = selectedDosen.length;
            $('#selectedDosenCount').text(`${count} dosen dipilih`);

            if (count > 0) {
                const names = selectedDosen.map(id => {
                    const dosen = dosenData.find(d => d.id === id);
                    return dosen ? dosen.name : '';
                }).filter(name => name).slice(0, 3);

                let displayText = names.join(', ');
                if (count > 3) {
                    displayText += ` dan ${count - 3} lainnya`;
                }
                $('#selectedDosenList').text(displayText);
            } else {
                $('#selectedDosenList').text('');
            }
        }

        function updateSelectedMahasiswaDisplay() {
            const count = selectedMahasiswa.length;
            $('#selectedMahasiswaCount').text(`${count} mahasiswa dipilih`);

            if (count > 0) {
                const names = selectedMahasiswa.map(id => {
                    const mahasiswa = mahasiswaData.find(m => m.id === id);
                    return mahasiswa ? mahasiswa.name : '';
                }).filter(name => name).slice(0, 3);

                let displayText = names.join(', ');
                if (count > 3) {
                    displayText += ` dan ${count - 3} lainnya`;
                }
                $('#selectedMahasiswaList').text(displayText);
            } else {
                $('#selectedMahasiswaList').text('');
            }
        }

        function updateHiddenInputs() {
            const hiddenInputsContainer = $('#hiddenInputs');
            hiddenInputsContainer.empty();

            // Add hidden inputs for dosen
            selectedDosen.forEach(id => {
                hiddenInputsContainer.append(`<input type="hidden" name="dosen_ids[]" value="${id}">`);
            });

            // Add hidden inputs for mahasiswa
            selectedMahasiswa.forEach(id => {
                hiddenInputsContainer.append(`<input type="hidden" name="mahasiswa_ids[]" value="${id}">`);
            });
        }

        // Form submission
        $('#kelasForm').submit(function(e) {
            if (selectedDosen.length === 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Warning!',
                    icon: 'warning',
                    html: 'Minimal pilih salah satu dosen pengajar untuk kelas ini.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                })
                return false;
            }

            if (selectedMahasiswa.length === 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Warning!',
                    icon: 'warning',
                    html: 'Minimal pilih salah satu mahasiswa untuk kelas ini.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                })
                return false;
            }

            // Update hidden inputs before submission
            updateHiddenInputs();

            // Form will be submitted normally to Laravel controller
            return true;
        });

        // Function untuk reset ke data awal (useful untuk cancel edit)
        function resetToOriginalData() {
            if (kelasData && kelasData.id) {
                selectedDosen = currentKelasDosen.map(item => item.dosen_id || item.id);
                selectedMahasiswa = currentKelasMahasiswa.map(item => item.mahasiswa_id || item.id);

                loadExistingKelasData();
            }
        }

        // Function untuk cek apakah ada perubahan
        function hasChanges() {
            if (!kelasData || !kelasData.id) return true; // Create mode, always has changes

            const originalDosenIds = currentKelasDosen.map(item => item.dosen_id || item.id).sort();
            const currentDosenIds = selectedDosen.slice().sort();

            const originalMahasiswaIds = currentKelasMahasiswa.map(item => item.mahasiswa_id || item.id).sort();
            const currentMahasiswaIds = selectedMahasiswa.slice().sort();

            const dosenChanged = JSON.stringify(originalDosenIds) !== JSON.stringify(currentDosenIds);
            const mahasiswaChanged = JSON.stringify(originalMahasiswaIds) !== JSON.stringify(currentMahasiswaIds);

            // Check form fields changes
            const formChanged =
                $('#nama_kelas').val() !== (kelasData.nama_kelas || '') ||
                $('#kode_kelas').val() !== (kelasData.kode_kelas || '') ||
                $('#deskripsi').val() !== (kelasData.deskripsi || '') ||
                $('#tahun_ajaran').val() !== (kelasData.tahun_ajaran || '') ||
                $('#semester').val() !== (kelasData.semester || '') ||
                $('#status').val() !== (kelasData.status || 'aktif');

            return dosenChanged || mahasiswaChanged || formChanged;
        }

        // Function to refresh data (useful for AJAX updates)
        function refreshData(newDosenData, newMahasiswaData) {
            dosenData = newDosenData;
            mahasiswaData = newMahasiswaData;

            dosenTable.clear().rows.add(dosenData).draw();
            mahasiswaTable.clear().rows.add(mahasiswaData).draw();
        }

        // Function to clear selections
        function clearSelections() {
            selectedDosen = [];
            selectedMahasiswa = [];
            updateSelectedDosenDisplay();
            updateSelectedMahasiswaDisplay();
            updateHiddenInputs();

            if (dosenTable) {
                dosenTable.draw();
            }
            if (mahasiswaTable) {
                mahasiswaTable.draw();
            }
        }
    </script>

</x-app-layout>

<div id="dosenModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="w-screen h-screen flex items-center justify-center p-4">
        <div class="bg-white w-full h-full rounded-sm flex flex-col">
            <div class="flex items-center justify-between p-6">
                <h3 class="text-xl font-semibold text-gray-800">Pilih Dosen Pengajar</h3>
                <button type="button" id="closeDosenModal" class="text-gray-400 cursor-pointer transition-all duration-200 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="flex-1 p-6 overflow-hidden">
                <div class="h-full flex flex-col">
                    <div class="flex-1 overflow-auto">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearchDosen"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>
                        <table id="dosenTable" class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="w-12">
                                        <input type="checkbox" id="selectAllDosen" class="rounded">
                                    </th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center">
                    <span id="dosenSelectionInfo" class="text-sm text-gray-600">0 dosen dipilih</span>
                    <div class="space-x-3">
                        <button type="button" id="cancelDosenSelection"
                            class="px-4 py-2 text-sm border cursor-pointer border-gray-300 text-gray-700 rounded-sm hover:bg-gray-500 hover:text-white transition-all duration-300">
                            Batal
                        </button>
                        <button type="button" id="confirmDosenSelection"
                            class="px-4 py-2 text-sm transition-all duration-300 cursor-pointer bg-blue-500 text-white rounded-sm hover:bg-blue-600">
                            Pilih Dosen (<span id="dosenSelectedCount">0</span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mahasiswa -->
<div id="mahasiswaModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="w-screen h-screen flex items-center justify-center p-4">
        <div class="bg-white w-full h-full rounded-sm flex flex-col">
            <div class="flex items-center justify-between p-6">
                <h3 class="text-xl font-semibold text-gray-800">Pilih Mahasiswa</h3>
                <button type="button" id="closeMahasiswaModal" class="text-gray-400 transition-all duration-300 cursor-pointer hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="flex-1 p-6 overflow-hidden">
                <div class="h-full flex flex-col">
                    <div class="flex-1 overflow-auto">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearchMahasiswa"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>
                        <table id="mahasiswaTable" class="w-full">
                            <thead>
                                <tr>
                                    <th class="w-12">
                                        <input type="checkbox" id="selectAllMahasiswa" class="rounded">
                                    </th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center">
                    <span id="mahasiswaSelectionInfo" class="text-sm text-gray-600">0 mahasiswa dipilih</span>
                    <div class="space-x-3">
                        <button type="button" id="cancelMahasiswaSelection"
                            class="px-4 text-sm py-2 cursor-pointer border border-gray-300 text-gray-700 hover:text-white transition-all duration-300 rounded-sm hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="button" id="confirmMahasiswaSelection"
                            class="px-4 py-2 text-sm transition-all duration-300 cursor-pointer bg-green-500 text-white rounded-sm hover:bg-green-600">
                            Pilih Mahasiswa (<span id="mahasiswaSelectedCount">0</span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>