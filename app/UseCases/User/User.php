<?php
namespace App\UseCases\User;

use App\Repositories\User\UserRepository;



class User
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserRepository
     */
    public function getUser()
    {
        return $this->user->getUser();
    }

    public function getUserById($userId){
        return $this->user->getUserDetailById($userId);
    }
}
