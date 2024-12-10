<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />

    <title>{{ config('app.name', 'eLumos') }} | @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#fafafa] dark:bg-gray-800 dark:text-gray-100">
    <div
        style="display: flex; justify-content: space-between; align-items: center; background-color: white; padding: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border-radius: 8px;">
        <div
            style="display: flex; gap: 8px; flex-direction: column; align-items: center; @media (min-width: 768px) { flex-direction: row; }">
            <img src="{{ $payment->photo }}" alt="photo payment status"
                style="width: 48px; height: 48px; border-radius: 8px;">
            <div>
                <h1 style="font-weight: bold; font-size: 1.25rem; color: #111827;">{{ $payment->title }}</h1>
                <p style="font-size: 0.875rem; color: #6b7280;">Transaction Id: <b>{{ $payment->transaction_id }}</b>
                </p>
                <p style="font-size: 0.875rem; color: #6b7280;">Transaction Date: <b>{{ $payment->created_at }}</b></p>
            </div>
        </div>
        <a href="{{ route('dashboard.orders.show.pdf', $payment->transaction_id) }}">
            <i
                style="cursor: pointer; border: 1px solid #d1d5db; color: #9ca3af; padding: 4px 12px; border-radius: 9999px; font-size: 1.125rem; transition-duration: 200ms; &:hover { border-color: #4b5563; color: #4b5563; }"></i>
        </a>
    </div>
    <hr style="display: block; width: 80%; margin: 16px auto; background-color: #64748b;">
    <div
        style="display: flex; justify-content: space-between; flex-direction: column; gap: 16px; @media (min-width: 768px) { flex-direction: row; }">
        <div
            style="background-color: white; padding: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border-radius: 8px; width: 100%; @media (min-width: 768px) { width: 66.6667%; }">
            <h2 style="font-weight: bold; font-size: 1.25rem; color: #111827; margin-bottom: 8px;">Enrolled Courses:
            </h2>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach ($payment->order['items'] as $item)
                    <div
                        style="display: flex; gap: 16px; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 2px solid #e5e7eb;">
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <img src="{{ $item['mockup'] }}" alt="Course Mockup"
                                style="width: 64px; height: 64px; border-radius: 8px;">
                            <div>
                                <h3
                                    style="font-weight: bold; font-size: 1.125rem; color: #374151; cursor: pointer; &:hover { color: #f59e0b; transition-duration: 200ms; }">
                                    <a href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </h3>
                                <h4 style="color: #374151;">Price: <b>{{ $item['amount'] }}</b></h4>
                            </div>
                        </div>
                        <a href="{{ $item['url'] }}"
                            style="border: 1px solid #d1d5db; color: #9ca3af; padding: 4px 8px; border-radius: 9999px; font-size: 0.875rem; transition-duration: 200ms; &:hover { border-color: #4b5563; color: #4b5563; }">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div
            style="background-color: white; padding: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border-radius: 8px; width: 100%; @media (min-width: 768px) { width: 33.3333%; }">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <h2 style="font-weight: bold; font-size: 1.25rem; color: #111827; margin-bottom: 8px;">Payment</h2>
                <img src="{{ asset('assets/images/icons/payments/' . $payment->payment_provider . '.png') }}"
                    alt="icon Payment" style="width: 48px;">
            </div>
            <hr>
            <div style="font-size: 0.875rem; color: #4b5563;">
                <p>- Status Payment: <b>{{ $payment->status }}</b></p>
                <p>- Payment Paid Amount: <b>{{ $payment->amount_paid }}</b></p>
                <p>- Total Price Order: <b>{{ $payment->order['discount'] }}</b></p>
                <p>- Used Wallet: <b style="color: #10b981;"> -{{ $payment->order['amount_use_wallet'] }}</b></p>
                <p>- Discount: <b style="color: #10b981;"> -{{ $payment->order['discount'] }}</b></p>
                <p>- Provider Payment: <b>{{ $payment->payment_provider }}</b></p>
                <p>- Type Method: <b>{{ $payment->payment_method }}</b></p>
                <p>- Transaction ID: <b>{{ $payment->transaction_id }}</b></p>
                <p>- Transaction Date: <b>{{ $payment->created_at }}</b></p>
                <p>- Payment Preview Date: <b>{{ $payment->payment_date }}</b></p>
            </div>
        </div>
    </div>


    {{-- Script JS --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
</body>

</html>
