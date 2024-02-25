<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  // Show/get all listings
  public function index()
  {
    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(2)
    ]);
  }

  // Show single listing
  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing
    ]);
  }

  // Show Create Form
  public function create() {
    return view('listings.create');
  }

  // Store Listing Data
  public function store(Request $request) {
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')],
      'location' => 'required', 
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);

    // creates 'logos' folder in storage->app->public
    if($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    // This line of code is assigning the currently authenticated user's ID to the 'user_id' key of the $formFields array. It uses Laravel's auth() helper function to get the authenticated user and then calls id() on the user object to retrieve the user's ID. This is commonly done to associate a form submission or a database record with the user who is currently logged in. 
    
    // The purpose of this operation is to manually associate the form submission with the user who made the request, by adding their user ID to the validated data. This is useful for when you're about to store the data in the database and you need to ensure that the record is linked to a specific user, especially when the form itself does not include a field for the user ID.
    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    return redirect('/')->with('message', 'Listing created successfully');
  }

  // Update Listing Data
  public function update(Request $request, Listing $listing)
  {

    // Make sure logged in user is owner
    if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'
      ],
      'tags' => 'required',
      'description' => 'required'
    ]);

    // creates 'logos' folder in storage->app->public
    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully');
  }

  // Show Edit Form
  public function edit(Listing $listing) {
    return view('listings.edit', ['listing' => $listing]);
  }

  // Delete Listing
  public function destroy(Listing $listing) {

    // Make sure logged in user is owner
    if ($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $listing->delete();
    return redirect('/')->with('message', 'Listing absolutely obliterated');
  }

  // Manage Listings
  public function manage() {
    return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
  }
}
