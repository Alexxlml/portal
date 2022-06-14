@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-verde-silconio-300 focus:ring focus:ring-verde-silconio-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
