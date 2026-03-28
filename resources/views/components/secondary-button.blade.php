<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-1 rounded-lg border border-red-600
    bg-red-500 text-white font-semibold
    hover:opacity-90']) }}>
    {{ $slot }}
</button>