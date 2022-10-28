<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Checkup2 extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'left_eye' => '',
        'left_eye2' => '',
        'right_eye' => '',
        'right_eye2' => '',
        'breath_vk' => '',
        'breath_feo' => '',
        'breath_tifno' => '',
        'hearing_loss_id' => '',
        'left_ear' => '',
        'right_ear' => '',
        'tone_audiometry' => '',
        'electrocardiogram' => '',
        'x_ray' => '',
        'echo_ray' => '',
    ];

    protected function rules(): array
    {
        return [
            'item.left_eye' => '',
            'item.left_eye2' => '',
            'item.right_eye' => '',
            'item.right_eye2' => '',
            'item.breath_vk' => '',
            'item.breath_feo' => '',
            'item.breath_tifno' => '',
            'item.hearing_loss_id' => '',
            'item.left_ear' => '',
            'item.right_ear' => '',
            'item.tone_audiometry' => '',
            'item.electrocardiogram' => '',
            'item.x_ray' => '',
            'item.echo_ray' => '',
        ];
    }

    protected $validationAttributes = [
        'item.left_eye' => 'Ляво око',
        'item.left_eye2' => 'Ляво око 2',
        'item.right_eye' => 'Дясно око',
        'item.right_eye2' => 'Дясно око 2',
        'item.breath_vk' => 'ВК',
        'item.breath_feo' => 'ФЕО 1',
        'item.breath_tifno' => 'Показател на Тифно',
        'item.hearing_loss_id' => 'Загуба на слуха',
        'item.left_ear' => 'Ляво ухо',
        'item.right_ear' => 'Дясно ухо',
        'item.tone_audiometry' => 'Диагноза',
        'item.electrocardiogram' => 'ЕКГ',
        'item.x_ray' => 'Рентгенография',
        'item.echo_ray' => 'Ехография',
    ];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $prophylacticCheckup = ProphylacticCheckup::findOrFail($prophylacticCheckupId);

        $this->item = [
            'left_eye' => $prophylacticCheckup->left_eye,
            'left_eye2' => $prophylacticCheckup->left_eye2,
            'right_eye' => $prophylacticCheckup->right_eye,
            'right_eye2' => $prophylacticCheckup->right_eye2,
            'breath_vk' => $prophylacticCheckup->breath_vk,
            'breath_feo' => $prophylacticCheckup->breath_feo,
            'breath_tifno' => $prophylacticCheckup->breath_tifno,
            'hearing_loss_id' => $prophylacticCheckup->hearing_loss_id,
            'left_ear' => $prophylacticCheckup->left_ear,
            'right_ear' => $prophylacticCheckup->right_ear,
            'tone_audiometry' => $prophylacticCheckup->tone_audiometry,
            'electrocardiogram' => $prophylacticCheckup->electrocardiogram,
            'x_ray' => $prophylacticCheckup->x_ray,
            'echo_ray' => $prophylacticCheckup->echo_ray,
        ];
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.checkup2');
    }

    public function save(): void
    {
        $this->validate();

        if (empty($this->item['hearing_loss_id'])) {
            $this->item['hearing_loss_id'] = null;
        }

        ProphylacticCheckup::findOrFail($this->prophylacticCheckupId)->update($this->item);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }
}
