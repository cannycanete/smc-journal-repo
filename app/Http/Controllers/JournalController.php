<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::all();
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
        $journals = Journal::where('user_id', auth()->user()->id)->get();
        return view('user-content.profile', ['journals' => $journals]);
    }

    public function create()
    {
        return view('user-content.create');
    }

    public function upload(Request $request)
    {
        try {
            // get file
            $journalFile = $request->file('journalFile');

            $journal = new Journal();

            $journal->user_id = $request->user()->id;
            $journal->title = $request->input('title');
            $journal->author = $request->input('author');
            $journal->publisher = $request->input('publisher');
            $journal->datePublished = $request->input('datePublished');
            $journal->abstract = $request->input('abstract');

            //move file to public/uploads folder & save file path to journals table & 
            $destinationPath = "uploads";
            $fileName = time() . '_' . $journalFile->getClientOriginalName();
            $journalFile->move($destinationPath, $fileName);
            $journal->filePath = $destinationPath . '/' . $fileName;
            $journal->fileName = $fileName;
            $journal->journalDownloadCounter = 0;

            $journal->save();
            // dd($request->user_id);

            return redirect(route('user-content.profile'))->with('success', 'Journal uploaded successfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'An error has occured.');
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

        return response()->download($path, $fileName);
    }
}
