<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-1 rounded-lg border border-red-600 opacity-85
    bg-red-500 text-white font-semibold
    hover:opacity-100']) }}>
    {{ $slot }}
</button>