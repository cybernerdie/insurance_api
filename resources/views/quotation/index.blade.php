<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get a Quote — Travel Insurance</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-lg mx-auto">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-bold text-gray-800">Travel Insurance Quote</h1>
            <button id="logout-btn" type="button" class="text-sm text-gray-500 hover:text-gray-800">Logout</button>
        </div>

        <div class="bg-white p-8 rounded shadow">
            <form id="quotation-form" novalidate class="space-y-4">
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">
                        Ages <span class="text-gray-400 font-normal">(comma-separated, e.g. 28,35)</span>
                    </label>
                    <input type="text" id="age" name="age" placeholder="28,35" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                    <span class="field-error text-xs text-red-600 mt-1 block" id="age-error"></span>
                </div>

                <div>
                    <label for="currency_id" class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                    <select id="currency_id" name="currency_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500 bg-white">
                        <option value="">Select currency</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->value }}">{{ $currency->value }}</option>
                        @endforeach
                    </select>
                    <span class="field-error text-xs text-red-600 mt-1 block" id="currency_id-error"></span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="start_date" name="start_date" required
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <span class="field-error text-xs text-red-600 mt-1 block" id="start_date-error"></span>
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="end_date" name="end_date" required
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <span class="field-error text-xs text-red-600 mt-1 block" id="end_date-error"></span>
                    </div>
                </div>

                <div id="form-error" class="text-sm text-red-600"></div>

                <button type="submit" class="w-full py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                    Get Quote
                </button>
            </form>
        </div>

        <div id="quotation-result" hidden class="mt-4 bg-white p-6 rounded shadow">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Your Quote</h2>
            <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                    <span>Total Price</span>
                    <strong id="result-total" class="text-gray-900"></strong>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span>Currency</span>
                    <strong id="result-currency" class="text-gray-900"></strong>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span>Quotation ID</span>
                    <strong id="result-id" class="text-gray-900"></strong>
                </div>
            </div>
        </div>

    </div>

    @vite(['resources/js/quotation.js'])
</body>
</html>
