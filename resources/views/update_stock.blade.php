<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Product Stock to default value 25') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="relative rounded-xl overflow-auto">
                        
                        <div class="shadow-sm overflow-hidden my-8">
                            <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('product.store_stock') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="productNo">
                                        Product No
                                    </label>
                                    <input name="productNo" id="productNo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>

                                <button type="submit" class="bg-blue-700 border-solid font-bold py-2 px-4 rounded">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>