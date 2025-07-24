<span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
       Status Bar
</span>

@php
    $color = $getRecord()?->color->hex_code ?? '#000000';
@endphp

<div class="w-full bg-primary-200 rounded-full h-2.5">
    <div class="rounded-full " style="background-color: {{ $color }}; height: 20px; color: white;">Hello</div>
</div>
