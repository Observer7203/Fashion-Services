@extends('layouts.app')

@section('content')
<!-- Including Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>

<!-- Хлебные крошки -->
<div class="bg-gray-100 py-8 mb-8 border-b" style=" background: url({{ asset('images/bg-breadcrumbs2.JPG') }}); background-size: cover; height: 500px;">
    <div class="container mx-auto max-w-7xl py-8 flex gap-8" style="height: inherit; flex-direction: column; justify-content: center; margin-left: 220px;">
        <h1 class="text-3xl font-bold mb-2" style="font-size: 49px; color: white; font-weight: 800;">CABINET</h1>
        <nav class="text-sm text-gray-600" style="font-size: 20px; color: white;">
            <a href="{{ route('home') }}" class="hover:underline">Home</a> > My Account
        </nav>
    </div>
</div>

<div class="container mx-auto max-w-7xl py-8 flex gap-8" style="margin-top: 30px; margin-bottom: 30px;">
    <!-- Sidebar -->
    <aside class="" style="margin-bottom: 25px;">
        <div class="w-64 bg-white border rounded shadow-sm-sm p-4 space-y-4" style="margin-bottom: 25px; margin-top: 25px; margin-left: 25px;">
        <div class="text-left">
            <div class="text-xl font-semibold mb-2">Hello, {{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
        </div>
        </div>
        <div class="text-left" style="margin-left: 25px;">
            <div class="text-xl font-semibold mb-2">My Account</div>
        </div>
        <div class="w-64 bg-white border rounded shadow-sm p-4 space-y-4" style="margin-bottom: 25px; margin-top: 25px; margin-left: 25px; height: 77%;">
        <nav class="space-y-2">
            <a href="{{ route('cabinet') }}" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="user" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Profile
                </span>
                <span>→</span>
            </a>
            <a href="{{ route('cabinet.orders.index') }}" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="shopping-cart" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Orders
                </span>
                <span>→</span>
            </a>
            <a href="{{ route('reservations.index') }}" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="calendar" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Reservations
                </span>
                <span>→</span>
            </a>
            <a href="#" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="heart" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Wishlist
                </span>
                <span>→</span>
            </a>
            <a href="#" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="credit-card" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Payment Methods
                </span>
                <span>→</span>
            </a>
            <a href="#" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="map-pin" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Shipping Addresses
                </span>
                <span>→</span>
            </a>
            <a href="#" class="flex justify-between items-center px-3 py-2 rounded menu-items">
                <span class="flex items-center gap-2" style="margin-right: 15px;">
                    <i data-lucide="bell" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Notifications
                </span>
                <span>→</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex justify-between items-center px-3 py-2 rounded text-red-500 menu-items">
                    <span class="flex items-center gap-2" style="margin-right: 15px;">
                        <i data-lucide="log-out" style="margin-right: 10px; stroke-width: 1px; width: 20px"></i> Logout
                    </span>
                    <span>→</span>
                </button>
            </form>
        </nav>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 grid grid-cols-2 gap-8" style="flex-wrap: wrap; display: flex; margin: 25px; gap: 20px; justify-content: space-between;">
        <!-- Profile block (spans both columns if desired, or fits in one) -->
        <div class="bg-white border rounded shadow-sm p-6 col-span-2" style="width: 48.9%; display:flex; flex-direction: column;">
            <h2 class="text-xl font-bold mb-4">Profile</h2>
            <div class="divide-y">
                <div class="py-2 flex justify-between"><span>First Name</span><span>{{ Auth::user()->name ?? 'Not specified' }}</span></div>
                <div class="py-2 flex justify-between"><span>Last Name</span><span>Not specified</span></div>
                <div class="py-2 flex justify-between"><span>Gender</span><span>Not specified</span></div>
                <div class="py-2 flex justify-between"><span>Date of Birth</span><span>Not specified</span></div>
                <div class="py-2 flex justify-between"><span>Email</span><span>{{ Auth::user()->email }}</span></div>
            </div>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>

        <!-- Other blocks -->
        <div class="bg-white border rounded shadow-sm p-6" style="width: 48.9%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">Notifications</h3>
            <p class="text-gray-500">No notifications yet.</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-6" style="width: 48.9%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">Order History</h3>
            <p class="text-gray-500">No orders yet.</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-6" style="width: 48.9%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">My Reservations</h3>
            <p class="text-gray-500">No reservations yet.</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-6" style="width: 48.9%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">Payment Methods</h3>
            <p class="text-gray-500 mb-4">No payment methods added.</p>
            <a href="#" class="button border border-gray-400 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-100 text-center">Add Payment Method</a>
        </div>

        <div class="bg-white border rounded shadow-sm p-6" style="width: 48.9%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">Shipping Addresses</h3>
            <p class="text-gray-500 mb-4">No shipping addresses added.</p>
            <a href="#" class="button border border-gray-400 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-100 text-center">Add Shipping Address</a>
        </div>

        <div class="bg-white border rounded shadow-sm p-6" style="width: 100%; display:flex; flex-direction: column;">
            <h3 class="text-lg font-bold mb-4">Wishlist</h3>
            <p class="text-gray-500">No wishlist items yet.</p>
        </div>
    </main>
    <style>
    .button:hover {
    background: rgb(240, 243, 245);
}
.button {
    all: unset;
    -webkit-box-align: center;
    align-items: center;
    box-sizing: border-box;
    cursor: pointer;
    display: inline-flex;
    -webkit-box-pack: center;
    justify-content: center;
    touch-action: none;
    user-select: none;
    color: rgb(25, 26, 27);
    line-height: 1.25rem;
    min-width: calc(70px + 3.125rem);
    flex-direction: row;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 4px;
    border-style: solid;
    border-width: 2px;
    gap: 8px;
    background: rgb(255, 255, 255);
    border-color: rgb(25, 26, 27);
    padding: 12px 24px;
}
.menu-items:hover span {
    transform: translateX(10px);
}
.menu-items span {
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.max-w-7xl {
    max-width: 85rem;
}
    </style>
</div>
@endsection