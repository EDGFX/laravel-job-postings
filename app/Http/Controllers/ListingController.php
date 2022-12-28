<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Listing;

class ListingController extends Controller
{
    //Showing Tags Based On URL Parameter can be done either via dependency injection into the index() method: 
    // public function index(Request $request)
    //
    // Or it can be done by simply using Laravel's built in request helper: 
    //request('ParameterHere')

    //Show All Listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    //Show Single Listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show Create Listing Form
    public function create() {
        return view('listings.create');
    }

    //Store Listing Data Into Database
    public function store(Request $request) {
        //Validate all form fields for correct parameters described below prior to submission.
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        //After form is validated and submitted, redirect user to the home page.
        return redirect('/')->with('message', 'List Was Created Successfully!');
    }

    //Show Edit Form
    public function editListing(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    //Update Listing Data In Database
    public function updateListing(Request $request, Listing $listing) {

        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        //Validate all form fields for correct parameters described below prior to submission.
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        //After form is validated and submitted, redirect user to the home page.
        return redirect('/listings/'. $listing->id)->with('message', 'Listing Was Updated Successfully!');
    }

    //Delete Listing
    public function deleteListing(Listing $listing) {
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing Was Deleted Successfully!');
    }


    public function manageListing() {
        return view('listings.manage', 
        [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
