<a {{ $attributes->merge(['class'=>'block mx-auto md:w-full my-4 px-4 py-1 text-center rounded-lg
    text-white bg-accent-500 border-accent-600 opacity-85 hover:opacity-100
    border md:border-gray-200 font-semibold md:shadow-lg md:text-accent-500 md:bg-white md:hover:bg-gray-100']) }}>
    {{$slot}}
</a>