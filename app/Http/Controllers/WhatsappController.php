<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\WhatsappJob;
use JetBrains\PhpStorm\NoReturn;

final class WhatsappController extends Controller
{
    public function webhook(): void
    {
        echo webhook();
    }

    #[NoReturn]
    public function receive(): void
    {
        WhatsappJob::dispatch(file_get_contents('php://input'));
        exit();
    }
}
