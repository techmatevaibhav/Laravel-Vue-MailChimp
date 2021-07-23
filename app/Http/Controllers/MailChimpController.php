<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;
use DrewM\MailChimp\MailChimp;

class MailChimpController extends Controller
{
    private $mailChimps;
    private $listId;


    public function __construct()
    {
        $this->mailChimps = new Mailchimp(config('newsletter.apiKey'));
        $this->listId = env('MAILCHIMP_LIST_ID');
    }

    /**
     * Below is the method for the create Contact In mailChimp
     */
    public function createContact(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        try {
            if (Newsletter::isSubscribed($request->email)) {
                return response(['Message' => 'Email already exist'], 403);
            } else {
                Newsletter::subscribe($request->email, ['FNAME' => $request->firstName, 'LNAME' => $request->lastName], false);
                // return response()->json('success');
                return response(['Message' => 'added successfully'], 200);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * below is the method for the get the list of all the Members
     */
    public function getListOfContacts()
    {
        $result = Newsletter::getMembers();
        return response()->json($result['members']);
    }

    /**
     * Below method for the delete Specific Contact
     * here we are deleting permanently and deleting by email.
     */
    public function deleteContactInfo($email)
    {

        if (Newsletter::hasMember($email)) {
            if (Newsletter::deletePermanently($email)) {
                return response(['Message' => 'deleted successfully'], 200);
            } else {
                return response(['Message' => 'something wrong'], 400);
            }
        } else {
            return response(['Message' => 'contact already deleted'], 200);
        }
    }

    /**
     * below method for the updateContactInfo
     * If email is not already used only in that case it will update
     */
    public function updateContactInfo($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        $emailAddress = $request['email'];
        $fName = $request['firstName'];
        $lName = $request['lastName'];

        try {

            $response = $this->mailChimps->put(
                'lists/' . $this->listId . '/members/' . $id,
                [
                    'email_address' => $emailAddress,
                    'merge_fields' => [
                        'FNAME' => $fName,
                        'LNAME' => $lName,
                    ],
                ]
            );
            if ($response['status'] == 'subscribed') {
                return response(['Message' => 'Updated Successfully'], 200);
            } else {
                return response(['Message' => 'something wrong'], 400);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Below is the method for the get the specific member info.
     * you will see commented code because before i get the list by Email and then i changes with
     * other way.
     */

    public function getContactById($id)
    {
        try {
            $contactInfo = $this->mailChimps->get('lists/' . $this->listId . '/members/' . $id);
            // $contactInfo = Newsletter::getMember($email);
            if ($contactInfo['status'] == 'subscribed') {
                $response = array(
                    'statusCode' => $contactInfo['status'],
                    'message' => 'Info of the contact',
                    'data' => $contactInfo
                );
            } else {
                $response = array(
                    'statusCode' => $contactInfo['status'],
                    'message' => 'No data available.',
                    'data' => $contactInfo
                );
            }

            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
