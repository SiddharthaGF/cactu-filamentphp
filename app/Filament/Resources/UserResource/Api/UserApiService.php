<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Api;

use App\Filament\Resources\UserResource;
use Rupadana\ApiService\ApiService;

final class UserApiService extends ApiService
{
    protected static string | null $resource = UserResource::class;

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
