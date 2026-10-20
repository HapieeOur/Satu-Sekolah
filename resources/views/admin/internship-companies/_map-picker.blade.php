@php
    $currentLat = old('latitude', isset($internshipCompany) ? $internshipCompany->latitude : null);
    $currentLng = old('longitude', isset($internshipCompany) ? $internshipCompany->longitude : null);
    $currentRadius = old('radius_meters', isset($internshipCompany) ? $internshipCompany->radius_meters : 100);
    $hasLocation = !is_null($currentLat) && !is_null($currentLng);
    
    // Default fallback center if no location set yet: Jakarta (-6.2088, 106.8456)
    $defaultLat = $currentLat ?? -6.2088;
    $defaultLng = $currentLng ?? 106.8456;
@endphp

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #company-map {
            z-index: 1;
        }
        .leaflet-pane {
            z-index: 10 !important;
        }
        .leaflet-top, .leaflet-bottom {
            z-index: 20 !important;
        }
        /* Custom animated pulsing marker radar */
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 0.4; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .pulse-circle {
            animation: pulse-ring 3s infinite ease-in-out;
        }
    </style>
@endpush

<div class="p-5 md:p-6 rounded-2xl border border-indigo-100 bg-gradient-to-b from-indigo-50/50 to-white shadow-xs space-y-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-indigo-100/70">
        <div class="flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-sm shadow-indigo-600/30 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            <div>
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    Lokasi Map & Radius Geofence PKL
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-100 text-indigo-700">Interaktif</span>
                </h3>
                <p class="text-[11px] text-slate-500">Cari nama lokasi atau seret pin pada peta untuk menentukan koordinat presensi siswa.</p>
            </div>
        </div>

        <button 
            type="button" 
            id="btn-my-location" 
            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-[11px] font-bold text-indigo-700 bg-white hover:bg-indigo-50 border border-indigo-200 rounded-xl shadow-xs transition cursor-pointer self-start sm:self-auto"
        >
            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3" stroke-width="2"/>
                <path stroke-linecap="round" stroke-width="2" d="M12 2v3m0 14v3m10-10h-3M5 12H2"/>
            </svg>
            <span>Lokasi Saya (GPS)</span>
        </button>
    </div>

    <!-- Search Box with Live Results -->
    <div class="relative">
        <label for="map-search-input" class="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[11px]">
            Cari Lokasi / Alamat Perusahaan di Peta
        </label>
        <div class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="map-search-input" 
                    placeholder="Ketik nama tempat, instansi, atau jalan (cth: Cyber 2 Jakarta, Telkom Malang)..." 
                    class="w-full pl-9 pr-10 py-2.5 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-slate-800 transition"
                    autocomplete="off"
                >
                <button 
                    type="button" 
                    id="btn-clear-search" 
                    class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <button 
                type="button" 
                id="btn-search-map" 
                class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5 cursor-pointer shrink-0"
            >
                <span id="btn-search-text">Cari</span>
                <span id="btn-search-spinner" class="hidden">
                    <svg class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>
        </div>

        <!-- Floating Autocomplete / Search Results Dropdown -->
        <div 
            id="search-results-dropdown" 
            class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden z-[999] max-h-60 overflow-y-auto"
        >
            <div id="search-results-list" class="divide-y divide-slate-100 text-xs"></div>
        </div>
    </div>

    <!-- Interactive Leaflet Map Container -->
    <div class="relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-inner bg-slate-100">
        <div id="company-map" class="w-full h-80 sm:h-96"></div>

        <!-- Map Floating Hint -->
        <div class="absolute bottom-3 left-3 right-3 sm:right-auto z-20 pointer-events-none">
            <div class="bg-slate-900/85 backdrop-blur-xs text-white text-[11px] px-3 py-1.5 rounded-xl shadow-lg border border-white/10 flex items-center gap-2 max-w-sm">
                <svg class="w-4 h-4 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Klik pada peta atau seret marker pin untuk menyesuaikan posisi gedung.</span>
            </div>
        </div>
    </div>

    <!-- Active Selected Location Box & Use Address Action -->
    <div id="location-preview-box" class="p-3.5 rounded-xl bg-white border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 animate-ping"></span>
                <span class="font-bold text-slate-800 text-[11px] uppercase tracking-wider">Lokasi Terpilih di Peta</span>
            </div>
            <p id="detected-address-text" class="text-slate-600 text-xs mt-1 truncate font-medium">
                {{ $hasLocation ? 'Koordinat aktif: ' . $currentLat . ', ' . $currentLng : 'Belum ada titik dipilih. Silakan cari lokasi atau klik peta.' }}
            </p>
        </div>
        <button 
            type="button" 
            id="btn-use-address" 
            class="hidden px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Gunakan Sebagai Alamat</span>
        </button>
    </div>

    <!-- Radius Geofence Configuration -->
    <div class="pt-3 border-t border-slate-200/80 space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <label for="radius_meters" class="block font-bold uppercase tracking-wider text-slate-700 text-[11px]">
                    Batas Radius Presensi Geofence (Meter) <span class="text-rose-500">*</span>
                </label>
                <p class="text-[11px] text-slate-500">Siswa hanya dapat presensi jika berada dalam lingkaran radius ini.</p>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-[11px] font-semibold text-slate-500">Radius Aktif:</span>
                <span id="radius-display-badge" class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-mono font-bold text-xs">
                    {{ $currentRadius }} m
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <!-- Slider -->
            <div class="sm:col-span-8 flex items-center gap-3">
                <span class="text-[10px] font-bold text-slate-400">20m</span>
                <input 
                    type="range" 
                    id="radius_slider" 
                    min="20" 
                    max="1000" 
                    step="10" 
                    value="{{ $currentRadius }}" 
                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600"
                >
                <span class="text-[10px] font-bold text-slate-400">1000m</span>
            </div>

            <!-- Number input -->
            <div class="sm:col-span-4">
                <div class="relative">
                    <input 
                        type="number" 
                        id="radius_meters" 
                        name="radius_meters" 
                        value="{{ $currentRadius }}" 
                        min="10" 
                        max="5000" 
                        required
                        class="w-full pr-12 pl-3 py-2 text-xs rounded-xl border @error('radius_meters') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 font-mono text-slate-800 transition"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 font-bold text-[11px]">
                        meter
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Radius Presets -->
        <div class="flex flex-wrap items-center gap-1.5 pt-1">
            <span class="text-[11px] font-semibold text-slate-500 mr-1">Pilihan Cepat:</span>
            <button type="button" class="btn-preset-radius px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-indigo-50 hover:border-indigo-200 transition cursor-pointer" data-radius="50">50 m</button>
            <button type="button" class="btn-preset-radius px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-indigo-50 hover:border-indigo-200 transition cursor-pointer" data-radius="100">100 m (Standar)</button>
            <button type="button" class="btn-preset-radius px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-indigo-50 hover:border-indigo-200 transition cursor-pointer" data-radius="200">200 m</button>
            <button type="button" class="btn-preset-radius px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-indigo-50 hover:border-indigo-200 transition cursor-pointer" data-radius="500">500 m</button>
        </div>
        @error('radius_meters')
            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Hidden / Advanced GPS Coordinates (Automatic sync with Map) -->
    <div class="pt-3 border-t border-slate-200/80">
        <details class="group">
            <summary class="flex items-center justify-between cursor-pointer list-none text-[11px] font-bold text-slate-600 hover:text-indigo-600 transition">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span>Detail Teknis Koordinat GPS (Terisi Otomatis)</span>
                </span>
                <span class="font-mono text-[10px] text-slate-400 group-open:hidden">
                    Lat: <span id="summary-lat">{{ $currentLat ?? '-' }}</span>, Lng: <span id="summary-lng">{{ $currentLng ?? '-' }}</span>
                </span>
            </summary>

            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                <div>
                    <label for="latitude" class="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[10px]">
                        Latitude
                    </label>
                    <input 
                        type="number" 
                        step="any" 
                        id="latitude" 
                        name="latitude" 
                        value="{{ $currentLat }}" 
                        placeholder="Contoh: -6.223400" 
                        class="w-full px-3 py-2 text-xs rounded-xl border @error('latitude') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 font-mono text-slate-800 transition"
                    >
                    @error('latitude')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="longitude" class="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[10px]">
                        Longitude
                    </label>
                    <input 
                        type="number" 
                        step="any" 
                        id="longitude" 
                        name="longitude" 
                        value="{{ $currentLng }}" 
                        placeholder="Contoh: 106.829100" 
                        class="w-full px-3 py-2 text-xs rounded-xl border @error('longitude') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 font-mono text-slate-800 transition"
                    >
                    @error('longitude')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2 text-[10px] text-slate-500">
                    💡 Anda juga bisa mengedit angka koordinat di atas secara manual jika memiliki data presisi dari Google Maps. Peta akan otomatis menyesuaikan diri.
                </div>
            </div>
        </details>
    </div>
</div>

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration & Initial State
            const hasInitialLocation = @json($hasLocation);
            let currentLat = @json($defaultLat);
            let currentLng = @json($defaultLng);
            let currentRadius = parseInt(@json($currentRadius)) || 100;
            let detectedAddress = '';

            // DOM Elements
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const radiusInput = document.getElementById('radius_meters');
            const radiusSlider = document.getElementById('radius_slider');
            const radiusBadge = document.getElementById('radius-display-badge');
            const summaryLat = document.getElementById('summary-lat');
            const summaryLng = document.getElementById('summary-lng');
            const searchInput = document.getElementById('map-search-input');
            const searchBtn = document.getElementById('btn-search-map');
            const searchBtnText = document.getElementById('btn-search-text');
            const searchSpinner = document.getElementById('btn-search-spinner');
            const clearSearchBtn = document.getElementById('btn-clear-search');
            const resultsDropdown = document.getElementById('search-results-dropdown');
            const resultsList = document.getElementById('search-results-list');
            const detectedAddressText = document.getElementById('detected-address-text');
            const useAddressBtn = document.getElementById('btn-use-address');
            const myLocationBtn = document.getElementById('btn-my-location');
            const companyNameInput = document.getElementById('name');
            const addressTextarea = document.getElementById('address');

            // Fix Leaflet icon paths
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            });

            // Initialize Map
            const initialZoom = hasInitialLocation ? 16 : 13;
            const map = L.map('company-map', {
                scrollWheelZoom: true,
            }).setView([currentLat, currentLng], initialZoom);

            // Add OpenStreetMap Tile Layer
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize Marker (Draggable)
            let marker = null;
            let radiusCircle = null;

            function renderMarkerAndCircle(lat, lng, radius) {
                if (!marker) {
                    marker = L.marker([lat, lng], {
                        draggable: true,
                        title: 'Geser untuk memindahkan titik lokasi'
                    }).addTo(map);

                    marker.on('dragend', function(e) {
                        const pos = marker.getLatLng();
                        updateCoordinates(pos.lat, pos.lng, true);
                    });
                } else {
                    marker.setLatLng([lat, lng]);
                }

                if (!radiusCircle) {
                    radiusCircle = L.circle([lat, lng], {
                        radius: radius,
                        color: '#4F46E5', // Indigo-600
                        fillColor: '#6366F1', // Indigo-500
                        fillOpacity: 0.18,
                        weight: 2,
                        dashArray: '4, 4'
                    }).addTo(map);
                } else {
                    radiusCircle.setLatLng([lat, lng]);
                    radiusCircle.setRadius(radius);
                }
            }

            // If we have an existing location or user is editing, render marker and circle
            if (hasInitialLocation) {
                renderMarkerAndCircle(currentLat, currentLng, currentRadius);
            }

            // Map click listener - move marker & update inputs
            map.on('click', function(e) {
                updateCoordinates(e.latlng.lat, e.latlng.lng, true);
            });

            // Update Coordinates Helper
            function updateCoordinates(lat, lng, doReverseGeocode = false) {
                currentLat = parseFloat(lat);
                currentLng = parseFloat(lng);

                // Update input values
                latInput.value = currentLat.toFixed(7);
                lngInput.value = currentLng.toFixed(7);

                if (summaryLat) summaryLat.textContent = currentLat.toFixed(6);
                if (summaryLng) summaryLng.textContent = currentLng.toFixed(6);

                renderMarkerAndCircle(currentLat, currentLng, currentRadius);

                if (doReverseGeocode) {
                    fetchReverseGeocode(currentLat, currentLng);
                }
            }

            // Reverse Geocoding (Nominatim OpenStreetMap)
            function fetchReverseGeocode(lat, lng) {
                detectedAddressText.textContent = 'Mendeteksi alamat dari peta...';
                useAddressBtn.classList.add('hidden');

                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`;
                fetch(url, {
                    headers: { 'Accept-Language': 'id,en' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        detectedAddress = data.display_name;
                        detectedAddressText.textContent = data.display_name;
                        useAddressBtn.classList.remove('hidden');

                        // If address textarea is currently empty, auto-populate it
                        if (addressTextarea && !addressTextarea.value.trim()) {
                            addressTextarea.value = data.display_name;
                        }
                    } else {
                        detectedAddressText.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    }
                })
                .catch(() => {
                    detectedAddressText.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
            }

            // "Gunakan Sebagai Alamat" Button Click
            useAddressBtn.addEventListener('click', function() {
                if (detectedAddress && addressTextarea) {
                    addressTextarea.value = detectedAddress;
                    addressTextarea.focus();
                    
                    // Small visual flash confirmation
                    const origText = useAddressBtn.innerHTML;
                    useAddressBtn.innerHTML = '<span>Tersalin! &#10003;</span>';
                    setTimeout(() => {
                        useAddressBtn.innerHTML = origText;
                    }, 2000);
                }
            });

            // Radius Change Sync (Input, Slider, Presets)
            function updateRadius(val) {
                currentRadius = Math.max(10, Math.min(5000, parseInt(val) || 100));
                radiusInput.value = currentRadius;
                radiusSlider.value = Math.min(1000, currentRadius);
                radiusBadge.textContent = currentRadius + ' m';

                if (radiusCircle) {
                    radiusCircle.setRadius(currentRadius);
                }
            }

            radiusInput.addEventListener('input', function() {
                updateRadius(this.value);
            });

            radiusSlider.addEventListener('input', function() {
                updateRadius(this.value);
            });

            document.querySelectorAll('.btn-preset-radius').forEach(btn => {
                btn.addEventListener('click', function() {
                    const preset = this.getAttribute('data-radius');
                    updateRadius(preset);
                });
            });

            // Manual Coordinate Input Listeners (when user expands technical details)
            latInput.addEventListener('change', function() {
                const val = parseFloat(this.value);
                if (!isNaN(val) && val >= -90 && val <= 90) {
                    updateCoordinates(val, currentLng, false);
                    map.setView([val, currentLng]);
                }
            });

            lngInput.addEventListener('change', function() {
                const val = parseFloat(this.value);
                if (!isNaN(val) && val >= -180 && val <= 180) {
                    updateCoordinates(currentLat, val, false);
                    map.setView([currentLat, val]);
                }
            });

            // Search Location (Nominatim)
            function performSearch() {
                const query = searchInput.value.trim();
                if (!query) return;

                searchSpinner.classList.remove('hidden');
                searchBtnText.classList.add('hidden');
                resultsDropdown.classList.add('hidden');
                resultsList.innerHTML = '';

                // Search OpenStreetMap Nominatim restricted to Indonesia (countrycodes=id)
                const searchUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=6&addressdetails=1`;

                fetch(searchUrl, {
                    headers: { 'Accept-Language': 'id,en' }
                })
                .then(res => res.json())
                .then(items => {
                    if (items && items.length > 0) {
                        resultsList.innerHTML = items.map((item, index) => {
                            const mainName = item.name || item.display_name.split(',')[0];
                            return `
                                <div class="search-result-item p-3 hover:bg-indigo-50/70 cursor-pointer transition flex items-start gap-2.5" data-index="${index}">
                                    <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-slate-800 text-xs">${mainName}</p>
                                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">${item.display_name}</p>
                                    </div>
                                </div>
                            `;
                        }).join('');

                        // Attach click handlers to result items
                        resultsList.querySelectorAll('.search-result-item').forEach(el => {
                            el.addEventListener('click', function() {
                                const idx = parseInt(this.getAttribute('data-index'));
                                const selected = items[idx];
                                if (selected) {
                                    const lat = parseFloat(selected.lat);
                                    const lon = parseFloat(selected.lon);

                                    map.flyTo([lat, lon], 17, { duration: 1.5 });
                                    updateCoordinates(lat, lon, false);

                                    detectedAddress = selected.display_name;
                                    detectedAddressText.textContent = selected.display_name;
                                    useAddressBtn.classList.remove('hidden');

                                    // If address textarea is empty, set it
                                    if (addressTextarea && !addressTextarea.value.trim()) {
                                        addressTextarea.value = selected.display_name;
                                    }

                                    // If company name is empty, suggest the place name
                                    if (companyNameInput && !companyNameInput.value.trim() && selected.name) {
                                        companyNameInput.value = selected.name;
                                    }

                                    resultsDropdown.classList.add('hidden');
                                }
                            });
                        });

                        resultsDropdown.classList.remove('hidden');
                    } else {
                        resultsList.innerHTML = `
                            <div class="p-4 text-center text-slate-500 text-xs">
                                <p class="font-semibold text-slate-700">Lokasi tidak ditemukan</p>
                                <p class="text-[11px] mt-1 text-slate-400">Coba gunakan nama jalan, kota, atau seret pin pada peta secara manual.</p>
                            </div>
                        `;
                        resultsDropdown.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    console.error('Search error:', err);
                    resultsList.innerHTML = `
                        <div class="p-4 text-center text-rose-600 text-xs">
                            <p class="font-semibold">Gagal memuat hasil pencarian</p>
                            <p class="text-[11px] mt-1 text-slate-500">Silakan coba lagi atau klik langsung pada peta.</p>
                        </div>
                    `;
                    resultsDropdown.classList.remove('hidden');
                })
                .finally(() => {
                    searchSpinner.classList.add('hidden');
                    searchBtnText.classList.remove('hidden');
                });
            }

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            // Show/hide clear search button
            searchInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                    resultsDropdown.classList.add('hidden');
                }
            });

            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                clearSearchBtn.classList.add('hidden');
                resultsDropdown.classList.add('hidden');
                searchInput.focus();
            });

            // Close results dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchBtn.contains(e.target) && !resultsDropdown.contains(e.target)) {
                    resultsDropdown.classList.add('hidden');
                }
            });

            // "Lokasi Saya (GPS)" Button Click
            if (myLocationBtn) {
                myLocationBtn.addEventListener('click', function() {
                    if (!navigator.geolocation) {
                        alert('Browser Anda tidak mendukung deteksi lokasi GPS.');
                        return;
                    }

                    const originalHTML = myLocationBtn.innerHTML;
                    myLocationBtn.disabled = true;
                    myLocationBtn.innerHTML = `
                        <svg class="animate-spin w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Mencari GPS...</span>
                    `;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            map.flyTo([lat, lng], 17, { duration: 1.5 });
                            updateCoordinates(lat, lng, true);

                            myLocationBtn.disabled = false;
                            myLocationBtn.innerHTML = originalHTML;
                        },
                        function(error) {
                            console.warn('Geolocation error:', error);
                            alert('Tidak dapat mendeteksi lokasi GPS Anda. Pastikan izin akses lokasi aktif di browser.');
                            myLocationBtn.disabled = false;
                            myLocationBtn.innerHTML = originalHTML;
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                });
            }

            // Invalidate map size after DOM is fully rendered so tiles render correctly
            setTimeout(() => {
                map.invalidateSize();
            }, 300);

            window.addEventListener('resize', () => {
                map.invalidateSize();
            });
        });
    </script>
@endpush
