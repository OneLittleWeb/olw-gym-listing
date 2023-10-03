<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\AwardCertificateRejectMail;
use App\Mail\AwardCertificateRequestMail;
use App\Models\AwardCertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class AwardController extends Controller
{
    public function awardCertificateRequest()
    {
        $award_certificate_requests = AwardCertificateRequest::whereNull('deleted_at')->latest()->get();

        return view('admin.award.award_certificate_request', compact('award_certificate_requests'));
    }

    public function awardCertificateUpdate($id, $status)
    {
        $award_certificate = AwardCertificateRequest::find($id);

        if ($award_certificate) {
            if ($status == 'approved') {

                $organization = $award_certificate->organization;

                //badges

                $files = File::files(public_path('images/badges'));
                $images = [];
                $organization_badge = '';

                foreach ($files as $file) {
                    $images[] = $file->getRelativePathname();

                    foreach ($images as $image) {
                        if ($image == $organization->category->name . ' - ' . $organization->city->name . '.png') {
                            $organization_badge = 'https://nebraskalisting.com/images/badges/' . $organization->category->name . ' - ' . $organization->city->name . '.png';
                        }
                    }
                }

                try {
                    $award_certificate->award_status = 1;
                    $award_certificate->update();

                    $award_certificate->organization_badge = '<img src="' . $organization_badge . '" alt="Nebraska Listing Badge"
                             style="display: block; margin-left: auto; margin-right: auto; width: 40%;">';

                    Mail::to($award_certificate->requested_user_email)->send(new AwardCertificateRequestMail($award_certificate));
                    alert()->success('Approved', 'The request for an award certificate has been approved, and the certificate has been sent to the requested business.');
                } catch (\Exception $e) {
                    alert()->error('error', 'Something went wrong sending the email to the user. Please try again later.');
                    return redirect()->back();
                }

            } elseif ($status == 'rejected') {

                try {
                    $award_certificate->award_status = 2;
                    $award_certificate->update();

                    Mail::to($award_certificate->requested_user_email)->send(new AwardCertificateRejectMail($award_certificate));
                    alert()->success('Rejected', 'Award certificate request has been rejected.');
                } catch (\Exception $e) {
                    alert()->error('error', 'Something went wrong sending the email to the user. Please try again later.');
                    return redirect()->back();
                }


            } elseif ($status == 'deleted') {

                $award_certificate->delete();

                alert()->success('Deleted', 'Award certificate request has been deleted.');
            }
            return back();
        }

        abort(404);
    }
}
