<?php

namespace Drewlabs\Laravel\Memory\Usage;

final class Middleware
{
    /** @var \Closure(\Drewlabs\Laravel\Memory\Usage\Log): void */
    private $dispatch;

    /**
     * Creates new middleware instance
     * 
     * @param \Closure(\Drewlabs\Laravel\Memory\Usage\Log): void $dispatch
     * 
     * @return void 
     */
    public function __construct(callable $dispatch)
    {
        $this->dispatch = $dispatch;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, callable $next)
    {
        # Call the dispatcher on the log instance
        $logger = Logger::create(sprintf('%s /%s', $request->method(), ltrim($request->path())), $this->dispatch);
        
        /** @var \Symfony\Component\HttpFoundation\Response */
        $response = $logger(function () use ($next, $request) {
            return $next($request);
        });

        # return the request response to the user
        return $response;
    }
}
