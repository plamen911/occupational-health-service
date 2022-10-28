<?php

declare(strict_types=1);

namespace App\Http\Livewire\Firms;

use App\Models\Firm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Form extends Component
{
    public Firm $firm;

    protected function rules(): array
    {
        return [
            'firm.name' => 'required|string|min:3|unique:firms,name' . (null !== $this->firm->getKey() ? ',' . $this->firm->getKey() : ''),
            'firm.manager' => '',
            'firm.address' => '',
            'firm.email' => '',
            'firm.phone1' => '',
            'firm.phone2' => '',
            'firm.notes' => '',
        ];
    }

    protected $validationAttributes = [
        'firm.name' => 'Наименование',
    ];

    public function render(): View
    {
        return view('livewire.firms.form');
    }

    public function save(): void
    {
        $this->validate();

        $this->firm->save();

        if ($this->firm->wasRecentlyCreated) {
            session()->flash('message', 'Фирмата бе добавена успешно.');

            $this->redirectRoute('firms.edit', $this->firm->id);
        } else {
            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'message' => 'Информацията бе съхранена успешно.',
            ]);
        }
    }
}
