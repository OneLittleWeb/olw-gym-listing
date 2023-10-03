<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\ClaimedBusiness;
use App\Mail\RejectClaimBusiness;
use App\Models\Contact;
use App\Models\ContactForClaimBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.contact.index');
    }

    public function contactForClaimBusiness()
    {
        $all_contacts_for_claim = ContactForClaimBusiness::withTrashed()->latest()->get();

        return view('admin.contact.contact_for_claim', compact('all_contacts_for_claim'));
    }

    public function ClaimStatusUpdate($id, $status)
    {
        $contact_claim = ContactForClaimBusiness::find($id);

        if ($contact_claim) {
            $organization = $contact_claim->organization;

            if ($status == 'approved') {
                $organization->is_claimed = 1;
                $organization->claimed_mail = $contact_claim->contact_email;
                $organization->update();
                $contact_claim->delete();

                try {
                    Mail::to($organization->claimed_mail)->send(new ClaimedBusiness($organization));
                    alert()->success('success', 'The business claim has been approved.');
                } catch (\Exception $e) {
                    alert()->error('error', 'Something went wrong sending the email to the user. Please try again later.');
                    return redirect()->back();
                }
            } else {
                $organization->claimed_mail = $contact_claim->contact_email;
                $organization->update();
                $contact_claim->delete();

                try {
                    Mail::to($organization->claimed_mail)->send(new RejectClaimBusiness($organization));
                    alert()->success('success', 'The business claim has been rejected.');
                } catch (\Exception $e) {
                    alert()->error('error', 'Something went wrong sending the email to the user. Please try again later.');
                }
            }
            return redirect()->back();
        }

        abort(404);
    }
}
