<?php

namespace Tests\Unit\App\Domain\Auth\Business;

use App\Application\Exceptions\UnauthorizedException;
use App\Domain\Auth\Business\AuthBusiness;
use App\Domain\Auth\Contracts\AuthRepositoryInterface;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Helper\AuthHelper;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repository\AuthRepository;
use \Mockery;
use Tests\TestCase;

class AuthBusinessTest extends TestCase
{
    private AuthBusiness $businessTested;

    protected function setUp():void
    {
        parent::setUp();
        $authRepositoryMock = Mockery::mock(AuthRepository::class);
        $authRepositoryMock
            ->shouldReceive('insertUser')
            ->andReturnArg(0);

        $this->businessTested = new AuthBusiness($authRepositoryMock);
    }


    /**
     * @test
     */
    public function deveLogarUsuario()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email'=> 'teste@teste.com',
            'password' => '123456'
        ]);
        AuthHelper::shouldReceive('attempt')
            ->andReturn('123456');
        AuthHelper::shouldReceive('user')
            ->andReturn($userDTO->toArray());
        $auth = $this->businessTested->login($userDTO);
        $this->assertEquals($userDTO->name,$auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);
    }
    /**
     * @test
     */
    public function naoDeveLogarUsuario()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email'=> 'teste@teste.com',
            'password' => '123456'
        ]);
        AuthHelper::shouldReceive('attempt')
            ->andReturn(null);
        AuthHelper::shouldReceive('user')
            ->andReturn($userDTO->toArray());

        $this->expectException(UnauthorizedException::class);
        $auth = $this->businessTested->login($userDTO);
    }

    /**
     * @test
     */
    public function deveCriarELogarUsuario()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email'=> 'teste@teste.com',
            'password' => '123456'
        ]);
        AuthHelper::shouldReceive('attempt')
            ->andReturn('123456');

        AuthHelper::shouldReceive('user')
            ->andReturn($userDTO->toArray());
        $auth = $this->businessTested->register($userDTO);
        $this->assertEquals($userDTO->name,$auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);
    }
    /**
     * @test
     */
    public function deveAtualizarToken()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email'=> 'teste@teste.com',
            'password' => '123456'
        ]);
        AuthHelper::shouldReceive('refresh')
            ->andReturn('123456');

        AuthHelper::shouldReceive('user')
            ->andReturn(new User($userDTO->toArray()));

        $auth = $this->businessTested->refresh($userDTO);
        $this->assertEquals($userDTO->name,$auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);
    }
}
