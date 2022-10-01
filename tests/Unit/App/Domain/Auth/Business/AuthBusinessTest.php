<?php

namespace Tests\Unit\App\Domain\Auth\Business;

use App\Application\Exceptions\UnauthorizedException;
use App\Domain\Auth\Business\AuthBusiness;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Helper\AuthHelper;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repository\AuthRepository;
use Mockery;
use PHPOpenSourceSaver\JWTAuth\Claims\Factory;
use Tests\TestCase;

class AuthBusinessTest extends TestCase
{
    private AuthBusiness $businessTested;
    private Factory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = $this->createMock(Factory::class);
        $this->factory
            ->method('getTTL')
            ->willReturn(1);
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
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);
        AuthHelper::shouldReceive('attempt')
            ->andReturn('123456');
        AuthHelper::shouldReceive('user')
            ->andReturn(new User($userDTO->toArray()));

        AuthHelper::shouldReceive('factory')
            ->andReturn(
                $this->factory
            );

        $auth = $this->businessTested->login($userDTO);
        $this->assertEquals($userDTO->name, $auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);
        $this->assertEquals(60, $auth->authorization['expires_in']);
    }

    /**
     * @test
     */
    public function naoDeveLogarUsuario()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);
        AuthHelper::shouldReceive('attempt')
            ->andReturn(null);
        AuthHelper::shouldReceive('user')
            ->andReturn($userDTO->toArray());
        AuthHelper::shouldReceive('factory')
            ->andReturn($this->factory);

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
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);
        AuthHelper::shouldReceive('factory')
            ->andReturn($this->factory);
        AuthHelper::shouldReceive('attempt')
            ->andReturn('123456');

        AuthHelper::shouldReceive('user')
            ->andReturn($userDTO->toArray());
        $auth = $this->businessTested->register($userDTO);
        $this->assertEquals($userDTO->name, $auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);

        $this->assertEquals(60, $auth->authorization['expires_in']);
    }

    /**
     * @test
     */
    public function deveAtualizarToken()
    {
        $userDTO = new UserDTO([
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);
        AuthHelper::shouldReceive('refresh')
            ->with(true, true)
            ->andReturn('123456');
        AuthHelper::shouldReceive('factory')
            ->andReturn($this->factory);
        AuthHelper::shouldReceive('user')
            ->andReturn(new User($userDTO->toArray()));

        $auth = $this->businessTested->refresh($userDTO);
        $this->assertEquals($userDTO->name, $auth->user->name);
        $this->assertEquals('123456', $auth->authorization['token']);
        $this->assertEquals('bearer', $auth->authorization['type']);

        $this->assertEquals(60, $auth->authorization['expires_in']);
    }
}
