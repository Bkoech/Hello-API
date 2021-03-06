<?php

namespace App\Containers\User\Actions;

use App\Containers\Authorization\Tasks\AssignRoleTask;
use App\Containers\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\User\Tasks\FireUserCreatedEventTask;
use App\Port\Action\Abstracts\Action;

/**
 * Class CreateUserAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateUserAction extends Action
{

    /**
     * @var  \App\Containers\User\Actions\CreateUserByCredentialsTask
     */
    private $createUserByCredentialsTask;

    /**
     * @var  \App\Containers\User\Actions\FireUserCreatedEventTask
     */
    private $fireUserCreatedEventTask;

    /**
     * @var  \App\Containers\Authorization\Tasks\AssignRoleTask
     */
    private $assignRoleTask;

    /**
     * CreateUserAction constructor.
     *
     * @param \App\Containers\User\Tasks\CreateUserByCredentialsTask $createUserByCredentialsTask
     * @param \App\Containers\User\Tasks\FireUserCreatedEventTask    $fireUserCreatedEventTask
     * @param \App\Containers\Authorization\Tasks\AssignRoleTask     $assignRoleTask
     */
    public function __construct(
        CreateUserByCredentialsTask $createUserByCredentialsTask,
        FireUserCreatedEventTask $fireUserCreatedEventTask,
        AssignRoleTask $assignRoleTask
    ) {
        $this->createUserByCredentialsTask = $createUserByCredentialsTask;
        $this->fireUserCreatedEventTask = $fireUserCreatedEventTask;
        $this->assignRoleTask = $assignRoleTask;
    }

    /**
     * create a new user object.
     * optionally can login the created user and return it with its token.
     *
     * @param      $email
     * @param      $password
     * @param      $name
     * @param      $gender
     * @param      $birth
     * @param bool $login determine weather to login or not after creating
     *
     * @return mixed
     */
    public function run($email, $password, $name, $gender = null, $birth = null, $login = false)
    {
        $user = $this->createUserByCredentialsTask->run($email, $password, $name, $gender, $birth, $login);

        // be default give all users the client role (normal user)
        $this->assignRoleTask->run($user, ['client']);

       //  add Client as role for normal users
        $this->fireUserCreatedEventTask->run($user);

        return $user;
    }
}
