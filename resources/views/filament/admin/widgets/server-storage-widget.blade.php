<x-filament::widget>
    <x-filament::card class="flex flex-col items-center p-6 space-y-4">
        <!-- أيقونة القرص الصلب -->
        <div class="w-full justify-center items-center text-center content-center flex mb-[15px]">
            <svg fill="{{ $this->getFillColor() }}" height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 507.908 507.908" xml:space="preserve">
            <g>
                <g>
                    <path d="M505.4,297.954c-0.1-0.2-82.4-217.9-82.7-218.4c-7.3-14-21.7-22.7-37.5-22.7H122.8c-15.8,0-30.2,8.7-37.5,22.7
                        c-0.3,0.5-82.7,218.2-82.7,218.4c-1.6,4.5-2.6,9.4-2.6,14.4v96.4c0,23.3,19,42.3,42.3,42.3h423.3c23.3,0,42.3-19,42.3-42.3v-96.4
                        C508,307.254,507.1,302.454,505.4,297.954z M68.8,202.454h40.9c7.8,0,14.1-6.3,14.1-14.1c0-7.8-6.3-14.1-14.1-14.1H79.5l10.7-28.3
                        h61.9c7.8,0,14.1-6.3,14.1-14.1c0-7.8-6.3-14.1-14.1-14.1h-51.2l9.7-25.8c2.5-4.3,7.1-6.9,12.2-6.9h262.5c5,0,9.6,2.6,12.2,7
                        l67.3,178H43.3L68.8,202.454z M465.7,422.854H42.3c-7.8,0-14.1-6.3-14.1-14.1v-96.4c0-7.8,6.3-14.1,14.1-14.1h423.3
                        c7.8,0,14.1,6.3,14.1,14.1v96.4h0.1C479.8,416.554,473.5,422.854,465.7,422.854z"/>
                </g>
            </g>
                <g>
                    <g>
                        <path d="M277,346.454H67.3c-7.8,0-14.1,6.3-14.1,14.1s6.3,14.1,14.1,14.1H277c7.8,0,14.1-6.3,14.1-14.1
                        C291.1,352.754,284.8,346.454,277,346.454z"/>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M440.7,346.454h-21.6c-7.8,0-14.1,6.3-14.1,14.1s6.3,14.1,14.1,14.1h21.6c7.8,0,14.1-6.3,14.1-14.1
                        C454.8,352.754,448.5,346.454,440.7,346.454z"/>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M356,346.454h-21.6c-7.8,0-14.1,6.3-14.1,14.1s6.3,14.1,14.1,14.1H356c7.8,0,14.1-6.3,14.1-14.1
                        C370.1,352.754,363.8,346.454,356,346.454z"/>
                    </g>
                </g>
        </svg>
        </div>

        <!-- شريط يعرض المساحة الإجمالية -->
        <div class="w-full bg-gray-200 rounded-full h-4 mb-[10px]">
            <div class=" h-4 rounded-full" style="width: {{ $this->getStorageInfo()['percentage_used'] }}%;background-color: {{ $this->getFillColor() }};"></div>
        </div>
        <p class="text-sm text-gray-600">{{ $this->getStorageInfo()['used'] }} / {{ $this->getStorageInfo()['total'] }} ({{ $this->getStorageInfo()['percentage_used'] }}% used)</p>
    </x-filament::card>
</x-filament::widget>