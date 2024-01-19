<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $journals = Journal::with('user')->get();
        $title = "";
        $author = "";
        return view('admin-content.index', [
            'journals' => $journals,
            'title' => $title,
            'author' => $author
        ]);
    }

    public function search(Request $request)
    {
        $title = $request->input('searchByTitle');
        $author = $request->input('searchByAuthor');

        $journals = Journal::where('title', $title)
            ->orWhere('author', $author)
            ->get();

        return view('admin-content.index', [
            'journals' => $journals,
            'title' => $title,
            'author' => $author
        ]);
    }

    public function profile($user_id)
    {
        $journals = Journal::where('user_id', $user_id)->get();
        $user = User::where('id', $user_id)->first();
        return view('admin-content.profile', ['journals' => $journals, 'user' => $user]);
    }

    public function journal($id)
    {
        $journal = Journal::findOrFail($id);
        return view('admin-content.journal', ['journal' => $journal]);
    }

    public function edit($id)
    {
        $journal = Journal::findOrFail($id);
        return view('admin-content.edit', ['journal' => $journal]);
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'datePublished' => 'required|date',
            'abstract' => 'required|string',
        ]);

        // Find the journal by ID
        $journal = Journal::findOrFail($id);

        // Update the journal with the validated data
        $journal->update($validatedData);

        // Redirect to the journal details page
        return redirect()->route('admin-content.journal', ['id' => $journal->id])->with('success', 'Journal updated successfully!');
    }

    public function destroy($id)
    {
        $journal = Journal::find($id);
        if (!$journal) {
            return redirect()->back()->with('error', 'Journal not found');
        }

        $journal->delete();

        return redirect()->back()->with('success-delete', 'Journal deleted successfully');
    }
}
