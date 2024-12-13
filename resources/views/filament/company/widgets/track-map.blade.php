<x-filament-widgets::widget>
    <x-filament::section>
        <!-- Add these lines in the head section -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet@^1.0.0/dist/leaflet-src.js"></script>
        <script src="https://unpkg.com/pouchdb@^5.2.0/dist/pouchdb.js"></script>
        <script src="https://unpkg.com/leaflet.tilelayer.pouchdbcached@latest/L.TileLayer.PouchDBCached.js"></script>

        <div
            id="map"
            class="map"
            style="height: 80vh; width: 100%;z-index: 1"
        ></div>

        <style>
            .button-9 {
                appearance: button;
                backface-visibility: hidden;
                background-color: #405cf5;
                border-radius: 6px;
                border-width: 0;
                box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset,rgba(50, 50, 93, .1) 0 2px 5px 0,rgba(0, 0, 0, .07) 0 1px 1px 0;
                box-sizing: border-box;
                color: #fff;
                cursor: pointer;
                font-family: -apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Ubuntu,sans-serif;
                font-size: 100%;
                height: 44px;
                line-height: 1.15;
                margin: 12px 0 0;
                outline: none;
                overflow: hidden;
                padding: 0 25px;
                position: relative;
                text-align: center;
                text-transform: none;
                transform: translateZ(0);
                transition: all .2s,box-shadow .08s ease-in;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                width: 100%;
                }

                .button-9:disabled {
                cursor: default;
                }

                .button-9:focus {
                box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .2) 0 6px 15px 0, rgba(0, 0, 0, .1) 0 2px 2px 0, rgba(50, 151, 211, .3) 0 0 0 4px;
                }
        </style>

        @vite(['resources/js/app.js'])

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map', {
                    fullscreenControl: true, // Add this line
                    fullscreenControlOptions: { // Optional: customize fullscreen control
                        position: 'topleft'
                    }
                });

                // Add tile layer
                L.tileLayer('{{ env("TILES_TRACK_URL", "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png") }}',{
                    useCache: true,
                    attribution: '© OpenStreetMap contributors',
                    crossOrigin: true,
                }).addTo(map);

                // Define custom icon
                const busIcon = L.icon({
                    iconUrl: '/bus-icon.png',
                    iconSize: [64, 64], // size of the icon
                    iconAnchor: [16, 60], // point of the icon which will correspond to marker's location
                    popupAnchor: [15, -64] // point from which the popup should open relative to the iconAnchor
                });

                const busGreanIcon = L.icon({
                    iconUrl: '/bus-icon-grean.png',
                    iconSize: [64, 64], // size of the icon
                    iconAnchor: [16, 60], // point of the icon which will correspond to marker's location
                    popupAnchor: [15, -64] // point from which the popup should open relative to the iconAnchor
                });

                // Handle buses
                const busMarkers = new Map();

                let buses = @json($this->getBuses());

                // Initialize markers for existing buses
                // In the track-map.blade.php file, modify the buses.forEach section:

                buses.forEach(bus => {
                    if (bus.latitude && bus.longitude) {
                        // Choose icon based on whether bus has active trip
                        const icon = bus.active_trip ? busGreanIcon : busIcon;

                        const marker = L.marker([bus?.latitude, bus.longitude], {
                            title: `${bus.number} : ${bus?.driver?.name ?? 'لا يوجد سائق'}`,
                            icon: icon
                        })
                        .bindPopup(`الحافله ${bus?.driver?.name ?? 'لا يوجد سائق'} (${bus.number})${bus.active_trip ? '<br>حالة الرحلة: قيد التشغيل' : ''}
                                <br>
                                ${bus?.active_trip ?
                                    `<a href="${bus?.active_trip?.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                        بيانات الرحلة
                                    </a>` : ''
                                }
                                <a href="${bus.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                    بيانات الحافلة
                                </a>
                                ${bus?.driver ?
                                    `<a href="${bus?.driver?.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                        بيانات السائق
                                    </a>` : ''
                                }

                        `)
                        .addTo(map);
                        busMarkers.set(bus.uuid, marker);
                    }

                    // Modify the Echo listener to maintain icon state
                    if (window.Echo) {
                        window.Echo.channel(`bus-location.${bus.uuid}`)
                            .listen('.client-update-location', (e) => {
                                let marker = busMarkers.get(bus.uuid);

                                // Choose icon based on whether bus has active trip
                                const icon = bus.active_trip ? busGreanIcon : busIcon;

                                if (!marker) {
                                    marker = L.marker([e.latitude, e.longitude], {
                                        title: `${bus.number} : ${bus?.driver?.name ?? 'لا يوجد سائق'}`,
                                        icon: icon
                                    })
                                    .bindPopup(`الحافله ${bus?.driver?.name ?? 'لا يوجد سائق'} (${bus.number})${bus.active_trip ? '<br>حالة الرحلة: قيد التشغيل' : ''}
                                            <br>
                                            ${bus?.active_trip ?
                                                `<a href="${bus?.active_trip?.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                                    بيانات الرحلة
                                                </a>` : ''
                                            }
                                            <a href="${bus.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                                بيانات الحافلة
                                            </a>
                                            ${bus?.driver ?
                                                `<a href="${bus?.driver?.edit_url}" style="color:white !important;text-align:center !important;" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg button-9 hover:bg-blue-700">
                                                    بيانات السائق
                                                </a>` : ''
                                            }
                                    `)
                                    .addTo(map);
                                    busMarkers.set(bus.uuid, marker);
                                } else {
                                    marker.setLatLng([e.latitude, e.longitude]);
                                    // Update the icon in case trip status changed
                                    marker.setIcon(icon);
                                }
                            });
                    }
                });

                // Handle user's location
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            map.setView([lat, lng], 13);
                        },
                        () => {
                            map.setView(@json($this->getMapCenter()), 13);
                        }
                    );
                }
            });
        </script>
    </x-filament::section>
</x-filament-widgets::widget>
