<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckMinistry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Storage::put('testurl',$request->path());
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->ministry) {

            if ($request->method()=='POST') {
                $whitelisted = array("mis");
                $whitelistedlinks = array("admin/candidates/candidate-api","admin/profile","admin/dashboard/job_roles/qualification");
                if (!in_array($request->segment(2), $whitelisted)) {
                    if (!in_array($request->path(), $whitelistedlinks)) {
                        return abort(403, "You are not Authorized for This Action" );
                    }
                }
            } else {
                $blacklistedlinks = array(
                    "admin/training_partners/partner-action",
                    "admin/training_centers/center-action",
                    "admin/trainer/trainer-action",
                    "admin/batches/batch-updates-action",
                    "admin/batches/batch-action",
                    "admin/assessor/assessor-action",
                    "admin/assessment/approve-reject",
                    "admin/assessment/certificate-release/approve-reject",
                    "admin/paymentorder/reject",
                    "admin/support/pending-request-assign",
                    "admin/support/stage-define"
                );
                foreach ($blacklistedlinks as $link) {
                    if (strpos( $request->path(), $link ) !== false) {
                        return abort(403, "You are not Authorized for This Action" );
                    }
                }

            }

        }
        return $next($request);
    }
}
