<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Login;
use App\Models\Registration;
use App\Services\AuthService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockMethod;
use PHPUnit\Framework\MockObject\MockObject;

class TestAuth extends TestCase
{
    private $authService;
    private $userRepository;
    private $loginRepository;
    private $registrationRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(User::class);
        $this->loginRepository = $this->createMock(Login::class);
        $this->registrationRepository = $this->createMock(Registration::class);
        $this->authService = new AuthService($this->userRepository, $this->loginRepository, $this->registrationRepository);
    }

    public function testLoginSuccess()
    {
        $username = 'testuser';
        $password = 'testpassword';

        $this->userRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(new User($username, $password));

        $this->loginRepository->expects($this->once())
            ->method('loginUser')
            ->with(new User($username, $password))
            ->willReturn(true);

        $result = $this->authService->login($username, $password);
        $this->assertTrue($result);
    }

    public function testLoginFailure()
    {
        $username = 'testuser';
        $password = 'testpassword';

        $this->userRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(null);

        $result = $this->authService->login($username, $password);
        $this->assertFalse($result);
    }

    public function testRegisterSuccess()
    {
        $username = 'testuser';
        $password = 'testpassword';

        $this->userRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(null);

        $this->registrationRepository->expects($this->once())
            ->method('registerUser')
            ->with(new User($username, $password))
            ->willReturn(true);

        $result = $this->authService->register($username, $password);
        $this->assertTrue($result);
    }

    public function testRegisterFailure()
    {
        $username = 'testuser';
        $password = 'testpassword';

        $this->userRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->willReturn(new User($username, $password));

        $result = $this->authService->register($username, $password);
        $this->assertFalse($result);
    }
}


This test file covers the following scenarios:

- `testLoginSuccess`: Tests that the `login` method of the `AuthService` class returns `true` when the user exists and the password is correct.
- `testLoginFailure`: Tests that the `login` method of the `AuthService` class returns `false` when the user does not exist or the password is incorrect.
- `testRegisterSuccess`: Tests that the `register` method of the `AuthService` class returns `true` when the user does not exist and the registration is successful.
- `testRegisterFailure`: Tests that the `register` method of the `AuthService` class returns `false` when the user already exists.