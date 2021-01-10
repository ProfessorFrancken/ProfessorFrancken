<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Activities\Comment;
use Francken\Association\Activities\CommentPolicy;
use Francken\Association\Activities\SignUp;
use Francken\Association\Activities\SignUpPolicy;
use Francken\Association\Boards\BoardMemberWasDemissioned;
use Francken\Association\Boards\BoardMemberWasDischarged;
use Francken\Association\Boards\BoardMemberWasInstalled;
use Francken\Association\Boards\MemberBecameCandidateBoardMember;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

final class ServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SignUp::class => SignUpPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register() : void
    {
        \Horizon::auth(function ($request) {
            $user = $request->user();

            if ($user === null) {
                return false;
            }

            return $user->hasRole('Admin');
        });
    }

    public function boot(Gate $gate) : void
    {
        $gate->before(fn ($user, $ability) : ?bool => $user->hasRole('Admin') ? true : null);

        $dispatcher = $this->app->make(Dispatcher::class);
        $dispatcher->listen(AccountWasActivated::class, ChangeRolesListener::class);
        $dispatcher->listen(BoardMemberWasDischarged::class, ChangeRolesListener::class);
        $dispatcher->listen(BoardMemberWasDemissioned::class, ChangeRolesListener::class);
        $dispatcher->listen(BoardMemberWasInstalled::class, ChangeRolesListener::class);
        $dispatcher->listen(MemberBecameCandidateBoardMember::class, ChangeRolesListener::class);
        $this->registerPolicies();
    }
}
