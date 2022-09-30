<?php
namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Prefix;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Post;

#[Prefix('auth')]
class AuthController extends Controller
{
    #[Post('register')]
    public function create(Request $request)
    {
        return response()->json(['teste' => 'true']);
    }
}
