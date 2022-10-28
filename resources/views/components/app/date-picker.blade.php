<input type="text"
       x-data="{ value: @entangle($attributes->wire('model')) }"
       x-ref="input"
       x-init="() => {
            $($refs.input).datepicker({
              changeMonth: true,
              changeYear: true,
              regional: 'bg',
              onSelect: function(dateText, inst) {
                console.log( dateText )
                $dispatch('input', dateText)
              }
            });
         }
       "
       wire:ignore
       x-bind:value="value"
       placeholder="Дата"
        {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md form-input focus:border-indigo-600']) }}
/>
