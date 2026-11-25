<?php

namespace App\Services;

use App\Models\CreditBusinessCalendar;
use App\Repositories\CreditBusinessCalendarRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreditBusinessCalendarService
{
    public function __construct(private readonly CreditBusinessCalendarRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditBusinessCalendar
    {
        return $this->repository->findOrFail($id, $include)->load('creditBusinessHolidays');
    }

    public function create(array $attributes): CreditBusinessCalendar
    {
        return DB::transaction(function () use ($attributes): CreditBusinessCalendar {
            $holidays = $attributes['holidays'] ?? [];
            unset($attributes['holidays']);
            $calendar = $this->repository->create($attributes);
            $this->saveHolidays($calendar, $holidays);
            return $calendar->load('creditBusinessHolidays');
        });
    }

    public function update(string $id, array $attributes): CreditBusinessCalendar
    {
        return DB::transaction(function () use ($id, $attributes): CreditBusinessCalendar {
            $holidays = $attributes['holidays'] ?? [];
            unset($attributes['holidays']);
            // The repository locks the parent until the complete transaction commits.
            $calendar = $this->repository->update($id, $attributes);
            $this->saveHolidays($calendar, $holidays);
            return $calendar->load('creditBusinessHolidays');
        });
    }

    private function saveHolidays(CreditBusinessCalendar $calendar, array $holidays): void
    {
        $existing = $calendar->creditBusinessHolidays()->lockForUpdate()->get()->keyBy('id');
        $occupied = $existing->keyBy('holiday_date');
        $seen = [];
        $seenIds = [];
        foreach ($holidays as $index => $holiday) {
            $id = $holiday['id'] ?? null;
            $date = $holiday['holiday_date'];
            if ($id !== null && (!$existing->has($id) || isset($seenIds[$id]))) {
                throw ValidationException::withMessages(["holidays.$index.id" => 'La fecha no pertenece a este calendario o está repetida.']);
            }
            if (isset($seen[$date]) || ($occupied->has($date) && $occupied->get($date)->id !== $id)) {
                throw ValidationException::withMessages(["holidays.$index.holiday_date" => 'La fecha ya está registrada en este calendario.']);
            }
            $seen[$date] = true;
            if ($id !== null) $seenIds[$id] = true;
        }
        foreach ($holidays as $holiday) {
            $id = $holiday['id'] ?? null;
            $values = [
                'holiday_date' => $holiday['holiday_date'],
                'description' => $holiday['description'],
                'recurring' => $holiday['recurring'] ?? false,
            ];
            if ($id !== null) {
                $existing->get($id)->update($values);
            } else {
                $calendar->creditBusinessHolidays()->create($values);
            }
        }
        // Omission never deletes persisted holidays or their identifiers.
    }
}
