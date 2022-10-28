<table {{ $attributes->merge(['class' => 'min-w-full leading-normal']) }}>
    @if(!empty($header))
        <thead>
            <tr>
                {{ $header }}
            </tr>
        </thead>
    @endif
    <tbody>
        {{ $slot }}
    </tbody>
</table>
