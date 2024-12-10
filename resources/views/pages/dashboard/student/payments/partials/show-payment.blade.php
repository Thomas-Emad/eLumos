<div class="flex justify-between items-center bg-white  p-3 border border-gray-200 shadow-md rounded-lg">
    <div class="flex gap-2 flex-col items-center md:flex-row">
        <img class="w-12 h-12 rounded-lg" src="{{ $payment->photo }}" alt="phone payment status">
        <div>
            <h1 class="font-bold text-2xl text-gray-900">{{ $payment->title }}</h1>
            <p class="text-sm text-gray-500">Transaction Id: <b>{{ $payment->transaction_id }}</b></p>
            <p class="text-sm text-gray-500">Transaction Date: <b>{{ $payment->created_at }}</b></p>
        </div>
    </div>
    <i
        class="fa-solid fa-print cursor-pointer border border-gray-400 hover:border-gray-600 text-gray-400 hover:text-gray-600 py-1 px-3 rounded-full text-lg duration-200"></i>
</div>
<hr class="block w-4/5 mx-auto my-4 bg-slate-500">
<div class="flex justify-between flex-col md:flex-row gap-4">
    <div class="bg-white  p-3 border border-gray-200 shadow-md rounded-lg w-full md:w-2/3">
        <h2 class="font-bold text-2xl text-gray-900 mb-2">Enrolled Courses:</h2>
        <div class="flex flex-col gap-2 ">
            @foreach ($payment->order['items'] as $item)
                <div class="flex gap-4 justify-between items-center pb-2 border-b-2 border-slate-2 ">
                    <div class="flex gap-2 items-center">
                        <img class="w-16 h-16 rounded-lg" src="{{ $item['mockup'] }}" alt="Course Mockup">
                        <div>
                            <h3
                                class="font-bold text-lg text-gray-700 hover:text-amber-700 duration-200 cursor-pointer">
                                <a href="{{ $item['url'] }}">
                                    {{ $item['title'] }}
                                </a>
                            </h3>
                            <h4 class="text-gray-700">Price: <b>{{ $item['amount'] }}</b></h3>
                        </div>
                    </div>
                    <a href="{{ $item['url'] }}"
                        class="border border-gray-400 hover:border-gray-600 text-gray-400 hover:text-gray-600 py-1 px-2 rounded-full text-sm duration-200">
                        <i class="fa-regular fa-eye"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white p-3 border border-gray-200 shadow-md rounded-lg w-full md:w-1/3">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-bold text-2xl text-gray-900 mb-2">Payment</h2>
            <img class="w-12" src="{{ asset('assets/images/icons/payments/' . $payment->payment_provider . '.png') }}"
                alt="icon Payment">
        </div>
        <hr>
        <div class="text-sm text-gray-600">
            <p>- Status Payment: <b>{{ $payment->status }}</b></p>
            <p>- Payment Paid Amount: <b>{{ $payment->amount_paid }}</b></p>
            <p>- Total Price Order: <b>{{ $payment->order['discount'] }}</b></p>
            <p>- Used Wallat: <b class="text-green-600"> -{{ $payment->order['amount_use_wallet'] }}</b></p>
            <p>- Discount: <b class="text-green-600"> -{{ $payment->order['discount'] }}</b></p>
            <p>- Provider Payment: <b>{{ $payment->payment_provider }}</b></p>
            <p>- Type Method: <b>{{ $payment->payment_method }}</b></p>
            <p>- Transaction ID: <b>{{ $payment->transaction_id }}</b></p>
            <p>- Transaction Date: <b>{{ $payment->created_at }}</b></p>
            <p>- Payment Preview Date: <b>{{ $payment->payment_date }}</b></p>
        </div>

    </div>
</div>
