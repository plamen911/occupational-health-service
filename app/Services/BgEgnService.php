<?php

declare(strict_types=1);

namespace App\Services;

use DateTime;
use Exception;
use InvalidArgumentException;

class BgEgnService
{
    private array $egnWeights;

    private array $egnRegions = [];

    private array $bgMonths;

    private string $egn;

    private int $year;

    private int $month;

    private int $day;

    private string $birthdayText;

    private int $sex;

    private string $sexText;

    private int $regionNum;

    private string $regionText;

    private int $birthNumber;

    public function __construct(string $egn)
    {
        $this->egnWeights = [2, 4, 8, 5, 10, 9, 7, 3, 6];

        /* Отделени номера */
        $this->egnRegions['Благоевград'] = 43; /* от 000 до 043 */
        $this->egnRegions['Бургас'] = 93;  /* от 044 до 093 */
        $this->egnRegions['Варна'] = 139; /* от 094 до 139 */
        $this->egnRegions['Велико Търново'] = 169; /* от 140 до 169 */
        $this->egnRegions['Видин'] = 183; /* от 170 до 183 */
        $this->egnRegions['Враца'] = 217; /* от 184 до 217 */
        $this->egnRegions['Габрово'] = 233; /* от 218 до 233 */
        $this->egnRegions['Кърджали'] = 281; /* от 234 до 281 */
        $this->egnRegions['Кюстендил'] = 301; /* от 282 до 301 */
        $this->egnRegions['Ловеч'] = 319; /* от 302 до 319 */
        $this->egnRegions['Монтана'] = 341; /* от 320 до 341 */
        $this->egnRegions['Пазарджик'] = 377; /* от 342 до 377 */
        $this->egnRegions['Перник'] = 395; /* от 378 до 395 */
        $this->egnRegions['Плевен'] = 435; /* от 396 до 435 */
        $this->egnRegions['Пловдив'] = 501; /* от 436 до 501 */
        $this->egnRegions['Разград'] = 527; /* от 502 до 527 */
        $this->egnRegions['Русе'] = 555; /* от 528 до 555 */
        $this->egnRegions['Силистра'] = 575; /* от 556 до 575 */
        $this->egnRegions['Сливен'] = 601; /* от 576 до 601 */
        $this->egnRegions['Смолян'] = 623; /* от 602 до 623 */
        $this->egnRegions['София - град'] = 721; /* от 624 до 721 */
        $this->egnRegions['София - окръг'] = 751; /* от 722 до 751 */
        $this->egnRegions['Стара Загора'] = 789; /* от 752 до 789 */
        $this->egnRegions['Добрич (Толбухин)'] = 821; /* от 790 до 821 */
        $this->egnRegions['Търговище'] = 843; /* от 822 до 843 */
        $this->egnRegions['Хасково'] = 871; /* от 844 до 871 */
        $this->egnRegions['Шумен'] = 903; /* от 872 до 903 */
        $this->egnRegions['Ямбол'] = 925; /* от 904 до 925 */
        $this->egnRegions['Друг/Неизвестен'] = 999; /* от 926 до 999 - Такъв регион понякога се ползва при
                                                                родени преди 1900, за родени в чужбина
                                                                или ако в даден регион се родят повече
                                                                деца от предвиденото. Доколкото ми е
                                                                известно няма правило при ползването
                                                                на 926 - 999 */
        asort($this->egnRegions);

        $this->bgMonths = [
            1 => 'януари',
            2 => 'февруари',
            3 => 'март',
            4 => 'април',
            5 => 'май',
            6 => 'юни',
            7 => 'юли',
            8 => 'август',
            9 => 'септември',
            10 => 'октомври',
            11 => 'ноември',
            12 => 'декември',
        ];

//        $egnRegionsLastNum = [];
//        $egnRegionsFirstNum = [];
//        $firstRegionNum = 0;
//        foreach ($this->egnRegions as $region => $lastRegionNum) {
//            $egnRegionsFirstNum[$firstRegionNum] = $lastRegionNum;
//            $egnRegionsLastNum[$lastRegionNum] = $firstRegionNum;
//            $firstRegionNum = $lastRegionNum + 1;
//        }

        $this->egn = $egn;

        if (! $this->isValid($this->egn)) {
            throw new InvalidArgumentException('EGN is not valid!');
        }

        $this->parse($this->egn);
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getBirthdayText(): string
    {
        return $this->birthdayText;
    }

    public function getSex(): int
    {
        return $this->sex;
    }

    public function getSexText(): string
    {
        return $this->sexText;
    }

    public function getRegionNum(): int
    {
        return $this->regionNum;
    }

    public function getRegionText(): string
    {
        return $this->regionText;
    }

    public function getBirthNumber(): int
    {
        return $this->birthNumber;
    }

    public function getEgn(): string
    {
        return $this->egn;
    }

    /** @throws Exception */
    public function getAge(): object
    {
        $date2 = new DateTime(sprintf('%04d-%02d-%02d', $this->getYear(), $this->getMonth(), $this->getDay()));
        $date1 = new DateTime('TODAY');

        $diff = $date2->diff($date1);

        return (object) [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];
    }

    /**
     * @description Check if EGN is valid, See: http://www.grao.bg/esgraon.html
     *
     * @param  string  $egn
     * @return bool
     */
    private function isValid(string $egn): bool
    {
        if (strlen($egn) !== 10) {
            return false;
        }

        $year = (int) substr($egn, 0, 2);
        $mon = (int) substr($egn, 2, 2);
        $day = (int) substr($egn, 4, 2);
        if ($mon > 40) {
            if (! checkdate($mon - 40, $day, $year + 2000)) {
                return false;
            }
        } elseif ($mon > 20) {
            if (! checkdate($mon - 20, $day, $year + 1800)) {
                return false;
            }
        } else {
            if (! checkdate($mon, $day, $year + 1900)) {
                return false;
            }
        }

        $checkSum = (int) substr($egn, 9, 1);
        $egnSum = 0;
        for ($i = 0; $i < 9; $i++) {
            $egnSum += (int) substr($egn, $i, 1) * $this->egnWeights[$i];
        }

        $validChecksum = $egnSum % 11;
        if ($validChecksum === 10) {
            $validChecksum = 0;
        }

        if ($checkSum === $validChecksum) {
            return true;
        }

        return false;
    }

    private function parse(string $egn): void
    {
        $this->year = (int) substr($egn, 0, 2);
        $this->month = (int) substr($egn, 2, 2);
        $this->day = (int) substr($egn, 4, 2);
        if ($this->month > 40) {
            $this->month -= 40;
            $this->year += 2000;
        } elseif ($this->month > 20) {
            $this->month -= 20;
            $this->year += 1800;
        } else {
            $this->year += 1900;
        }

        $this->birthdayText = $this->day.' '.$this->bgMonths[$this->month].' '.$this->year.' г.';
        $region = (int) substr($egn, 6, 3);
        $this->regionNum = $region;
        $this->sex = substr($egn, 8, 1) % 2;
        $this->sexText = (! $this->sex) ? 'М' : 'Ж';

        $firstRegionNum = 0;
        foreach ($this->egnRegions as $regionName => $lastRegionNum) {
            if ($region >= $firstRegionNum && $region <= $lastRegionNum) {
                $this->regionText = $regionName;
                break;
            }
            $firstRegionNum = $lastRegionNum + 1;
        }
        if ((int) substr($egn, 8, 1) % 2 !== 0) {
            $region--;
        }

        $this->birthNumber = ($region - $firstRegionNum) / 2 + 1;
    }
}
