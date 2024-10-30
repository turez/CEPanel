<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders in progress') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="relative rounded-xl overflow-auto">
                        <div class="shadow-sm overflow-hidden my-8">

                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-4">GTIN</th>
                                        <th scope="col" class="px-6 py-4">Name</th>
                                        <th scope="col" class="px-6 py-4">Total Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topProducts as $topProduct)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $topProduct['gtin'] ?? 'N/A' }} </td>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $topProduct['productName'] }} </td>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $topProduct['totalQuantity'] }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>