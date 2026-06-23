<?php

namespace App\Dto;

class TaskDto extends Dto
{
    public string $title;
    public ?string $description = null;
    public ?string $due_date = null;
    public ?string $create_date = null;
    public ?string $status = null;
    public ?string $priority = null;
    public ?string $category = null;
}
