<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('approval', 'approved')->get();
        $title = "";
        $author = "";
        return view('user-content.index', [
            'journals' => $journals,
            'title' => $title,
            'author' => $author
        ]);
    }

    public function profile()
    {
        $journals = Journal::where('user_id', auth()->user()->id)->where('approval', 'approved')->get();
        return view('user-content.profile', ['journals' => $journals]);
    }

    public function pending()
    {
        $journals = Journal::where('user_id', auth()->user()->id)->where('approval', 'pending')->get();
        return view('user-content.pending', ['journals' => $journals]);
    }

    public function create()
    {
        return view('user-content.create');
    }

    public function upload(Request $request)
    {
        try {
            // Get files
            $journalFile = $request->file('journalFile');
            $authorImage = $request->file('authorImage');
            $coAuthorImage = $request->file('coAuthorImage');

            // Create new Journal instance
            $journal = new Journal();

            // Set attributes for document/journal
            $journal->user_id = $request->user()->id;
            $journal->title = $request->input('title');
            $journal->author = $request->input('author');
            $journal->publisher = $request->input('publisher');
            $journal->datePublished = $request->input('datePublished');
            $journal->abstract = $request->input('abstract');
            $journal->journalDownloadCounter = 0;
            $journal->journalViewCounter = 0;
            $journal->approval = "pending";

            // Move document/journal file to public/uploads folder
            $destinationPath = "uploads";
            $fileName = time() . '_' . $journalFile->getClientOriginalName();
            $journalFile->move($destinationPath, $fileName);
            $journal->filePath = $destinationPath . '/' . $fileName;
            $journal->fileName = $fileName;

            // Move author image to public/img folder
            $imgDestinationPath = "uploads-author-img";
            $authorImageName = time() . '_author_' . $authorImage->getClientOriginalName();
            $authorImage->move($imgDestinationPath, $authorImageName);
            $journal->authorImage = $imgDestinationPath . '/' . $authorImageName;

            // Move co-author image to public/img folder
            $coAuthorImageName = time() . '_coauthor_' . $coAuthorImage->getClientOriginalName();
            $coAuthorImage->move($imgDestinationPath, $coAuthorImageName);
            $journal->coAuthorImage = $imgDestinationPath . '/' . $coAuthorImageName;

            // Save the journal entry
            $journal->save();

            return redirect(route('user-content.pending'))->with('success', 'Journal uploaded successfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'An error has occurred.');
        }
    }

    public function search(Request $request)
    {
        $title = $request->input('searchByTitle');
        $author = $request->input('searchByAuthor');

        $journals = Journal::where('title', $title)
            ->orWhere('author', $author)
            ->get();

        return view('user-content.index', [
            'journals' => $journals,
            'title' => $title,
            'author' => $author
        ]);
    }

    public function journal($id)
    {
        $journal = Journal::findOrFail($id);

        // Increment view counter
        $journal->journalViewCounter += 1;
        $journal->save();

        return view('user-content.journal', ['journal' => $journal]);
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

    public function download($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->journalDownloadCounter = $journal->journalDownloadCounter + 1;
        $journal->save();

        // Download the file
        $path = public_path($journal->filePath);
        $fileName = $journal->fileName;

        // return response()->download($path, $fileName);
        return redirect()->back()->with('success', 'Adjustment(s) created successfully!');
    }
}
