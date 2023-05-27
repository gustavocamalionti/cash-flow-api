<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class BaseService implements ServiceInterface

{
    /**
     * Retrieve authenticated user information
     */
    public function getUserAuth()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Get general appication parameters. Example: start and end time allowing transfers in day.
     */
    public function getParameters()
    {
        // return $this->parametersRepository->findById(1);
    }
}
