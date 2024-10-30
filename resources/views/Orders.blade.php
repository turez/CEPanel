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
                                        <th scope="col" class="px-6 py-4">Order No</th>
                                        <th scope="col" class="px-6 py-4">Date</th>
                                        <th scope="col" class="px-6 py-4">Status</th>
                                        <th scope="col" class="px-6 py-4">GTIN</th>
                                        <th scope="col" class="px-6 py-4">Product No</th>
                                        <th scope="col" class="px-6 py-4">Name</th>
                                        <th scope="col" class="px-6 py-4">Quantity</th>
                                        <th scope="col" class="px-6 py-4">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @foreach ($order['orderLines'] as $orderLine)
                                            <tr>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $order['orderNo'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $order['createdAt'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $orderLine['status'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $orderLine['gtin'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-7"> {{ $orderLine['productNo'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $orderLine['productName'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $orderLine['quantity'] }} </td>
                                                <td class="whitespace-nowrap px-6 py-4"> {{ $orderLine['totalIncVat'] }} </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $orders->render() }}
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>