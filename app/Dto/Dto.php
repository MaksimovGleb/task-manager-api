<?php

namespace App\Dto;

abstract class Dto
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn($value) => !is_null($value));
    }
}
