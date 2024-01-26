<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasEvaluationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->hasRight("review_evaluations"))
            return $next($request);

        $userEvaluations = Auth::user()->evaluations()->get();
        $accessibleThroughCompanyAccess = Auth::user()->companyEvaluations();

        if ($request->evaluation &&
            !$userEvaluations->contains("evaluationid", $request->evaluation->evaluationid) &&
            !$accessibleThroughCompanyAccess->contains("evaluationid", $request->evaluation->evaluationid)
        ) return redirect()->route("home")->with('warning', 'Access denied');

        return $next($request);
    }
}
