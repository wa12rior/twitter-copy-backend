<?php

declare(strict_types=1);

namespace App\Tests\Utils;

use App\Entity\User;

final class UserBuilder {

    public function __construct(
        private string $email,
        private string $username,
        private array $roles = [],
        private string $password,
    ) {
    }

    public function setEmail(string $email): self
    {
        $builder = clone $this;
        $builder->email = $email;

        return $builder;
    }

    public function setUsername(string $username): self
    {
        $builder = clone $this;
        $builder->username = $username;

        return $builder;
    }

    public function setRoles(array $roles): self
    {
        $builder = clone $this;
        $builder->roles = $roles;

        return $builder;
    }

    public function setPassword(string $password): self
    {
        $builder = clone $this;
        $builder->password = $password;

        return $builder;
    }

    public static function create(): self
    {
        return new self(
            'email@test.test',
            'custom.username',
            [],
            'secretP4sswd#',
        );
    }

    public function build(): User
    {
        $user = new User();
        $user->setEmail($this->email);
        $user->setUsername($this->username);
        $user->setRoles($this->roles);
        $user->setPassword($this->password);

        return $user;
    }
}
