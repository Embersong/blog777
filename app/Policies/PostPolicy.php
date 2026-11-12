<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Определяем, может ли пользователь просматривать список постов
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Определяем, может ли пользователь просматривать конкретный пост
     */
    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Определяем, может ли пользователь создавать посты
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Определяем, может ли пользователь обновлять пост
     */
    public function update(User $user, Post $post): bool
    {
        //Админ может все
        if ($user->is_admin) {
            return true;
        }

        return $post->isAuthor($user);
    }

    /**
     * Удалять пост может админ (любой пост) или автор (только свой).
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->isAdmin) {
            return true;
        }

        return $post->isAuthor($user);
    }


}
