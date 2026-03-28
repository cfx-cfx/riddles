<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-1 rounded-lg border border-accent-600
    bg-accent-500 text-white font-semibold opacity-90
    hover:opacity-100']) }}>
    {{ $slot }}
</button>