
<x-filament-widgets::widget>
    <x-filament::section>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <title>{{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"  rel="stylesheet" />
    <script>
        console.log('test');
    </script>
</head>
<body>
    <div class="relative" x-data="{ state: false }">
        <div class="absolute inset-0 blur-xl h-[580px]" style="
          background: linear-gradient(
            143.6deg,
            rgba(192, 132, 252, 0) 20.79%,
            rgba(232, 121, 249, 0.26) 40.92%,
            rgba(204, 171, 238, 0) 70.35%
          );
        "></div>
        <div class="relative">
            <section>
                <div style="padding-bottom: 30px;" class="max-w-screen-xl gap-12 px-4 mx-auto overflow-hidden text-gray-600 py-28 md:px-8 md:flex">
                    <div class="flex-none max-w-xl space-y-5">
                        <a href="#" class="inline-flex items-center p-1 pr-6 text-sm font-medium duration-150 border rounded-full gap-x-6 hover:bg-white">
                            <span class="inline-block px-3 py-1 text-white bg-indigo-600 rounded-full">New</span>
                            <p class="flex items-center">Comfort, speed, and affordability with a touch of Movment.</p>
                        </a>
                        <h1 class="text-4xl font-extrabold text-gray-800 sm:text-5xl">Welcome to {{ env('APP_NAME') }}</h1>
                        <p>Movment app analyzes real-time location data to optimize bus routes based on population density and traffic, providing accurate bus locations and times via GPS, and reducing congestion with proactive route adjustments and predictive analytics.</p>
                    </div>
                    <div class="flex-1 hidden md:block"><img style="height: 80%;" src="https://raw.githubusercontent.com/sidiDev/remote-assets/c86a7ae02ac188442548f510b5393c04140515d7/undraw_progressive_app_m-9-ms_oftfv5.svg" class="max-w-xl"/></div>
                </div>
            </section>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="width: 90%;margin: auto;margin-bottom: 70px;">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Application File</th>
                <th scope="col" class="px-6 py-3" style="text-align: right;padding-right: 45px;">Download</th>
            </tr>
            </thead>
            <tbody>
                @foreach(\Illuminate\Support\Facades\File::files(public_path('apps')) as $file)
                    <tr class="border-b odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $file->getFilename() }}
                        </th>
                        <td class="px-6 py-4" style="text-align: right;">
                            <a download href="\apps\{{ $file->getFilename() }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>
</html>

</x-filament::section>
</x-filament-widgets::widget>
