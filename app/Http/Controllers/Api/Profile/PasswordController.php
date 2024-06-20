<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChnagePasswordRequest;
use Illuminate\Http\Request;
use App\Customs\Services\PasswordService;


class PasswordController extends Controller
{
    public function __construct( private PasswordService $service)
      {

      }
    public function ChangeUserPassword(ChnagePasswordRequest $request)
    {
return $this->service->changePassword($request->validated());
    }
}
