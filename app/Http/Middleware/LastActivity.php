<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach(array_keys(config('auth.guards')) as $guard) {

            $user = Auth::guard($guard)->user();

            if ($user) {
                $this->updateLastActivityField($user);
            }
        }

        return $next($request);
    }

    /**
     * Updates the last activity field for a specified model.
     *
     * @param Model $user
     */
    protected function updateLastActivityField(Model $user)
    {
        $lastActivityField = 'last_activity_at';
        $graceTime = 5;

        if ($graceTime > 0 && $user->$lastActivityField && (new Carbon($user->$lastActivityField))->addSeconds($graceTime) > now()) {
            return;
        }

        $this->hideFromEvents($user, function() use ($user, $lastActivityField) {
            $user->$lastActivityField = now();
            $user->save();
        });
    }

    /**
     * Hides the functionality of a specified callback from the event dispatcher
     * of the specified modal. This prevents triggering model events and/or observers.
     *
     * @param Model $model
     * @param callable $callback
     * @return mixed
     */
    protected function hideFromEvents(Model $model, callable $callback)
    {
        $dispatcher = $model::getEventDispatcher();
        $model::unsetEventDispatcher();

        $result = $callback();

        $model::setEventDispatcher($dispatcher);

        return $result;
    }
}
