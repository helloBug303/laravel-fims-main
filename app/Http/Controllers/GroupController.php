<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;


class GroupController extends Controller
{

     // Display a page to manage groups
     
    // Display all groups
    public function index()
    {
        // Fetch all groups
        $groups = Group::all();
        return view('group.index', compact('groups'));
    }

    // Show the form to create a new group
    public function create()
    {
        return view('group.create');
    }

    // Store the new group
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'group_name' => 'required|string|max:255|unique:groups,group_name', // Ensure group_name is unique
            'group_level' => 'required|string|max:255|unique:groups,group_level', // Ensure group_level is unique
        ]);

        // Create the new group
        Group::create($validated);

        // Redirect to the groups index page with a success message
        return redirect()->route('group.index')->with('msg', 'Group has been created successfully!');
    }

    // Show the form to edit an existing group
    public function edit($id)
    {
        // Find the group by ID or fail
        $group = Group::findOrFail($id);
        return view('group.edit', compact('group'));
    }

    // Update the group
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'group_name' => 'required|string|max:255|unique:groups,group_name,' . $id, // Ignore uniqueness check for the current record
            'group_level' => 'required|string|max:255|unique:groups,group_level,' . $id, // Ignore uniqueness check for the current record
        ]);

        // Find the group and update
        $group = Group::findOrFail($id);
        $group->update($validated);

        // Redirect to the groups index page with a success message
        return redirect()->route('group.index')->with('msg', 'Group has been updated successfully!');
    }

    // Delete the group
    public function destroy($id)
    {
        // Find the group and delete it
        $group = Group::findOrFail($id);
        $group->delete();

        // Redirect to the groups index page with a success message
        return redirect()->route('group.index')->with('msg', 'Group has been deleted successfully!');
    }
}
