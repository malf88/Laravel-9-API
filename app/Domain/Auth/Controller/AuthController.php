<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Auth\Contracts\AuthBusinessInterface;
use App\Domain\Auth\DTO\UserDTO;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('auth')]
#[Middleware(['api'])]
class AuthController extends Controller
{
    public function __construct(
        private AuthBusinessInterface $authBusiness
    ) {
    }

    #[Post('register')]
    public function create(Request $request)
    {
        $userDto = new UserDTO($request->all());

        return response()->json($this->authBusiness->register($userDto));
    }

    #[Post('login')]
    public function login(Request $request)
    {
        $userDto = new UserDTO($request->all());

        return response()->json($this->authBusiness->login($userDto));
    }

    #[Patch('refresh', middleware:['auth:api', 'api'])]
    public function refresh()
    {
        return response()->json($this->authBusiness->refresh());
    }
}
