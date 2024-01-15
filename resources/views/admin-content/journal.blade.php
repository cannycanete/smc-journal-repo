@extends('layout')

@section('content')
    <div class="main main-expanded">
        <div class="row m-bot flex">
            <div class="col-md-3">
                <a href="{{ route('admin-content.index') }}" class="nav-title-container flex">
                    <img src="{{ asset('img/mysmc.png') }}" alt="mysmclogo" class="img-nav-logo">
                    <p class="nav-sub-text">Research Journal Online Repository <span class="text-bold">Admin</span></p>
                </a>
            </div>

            <div class="col-md-9 flex">
                <div class="flex right-pos-m" style="gap: 0.5rem">
                    <i class="bi bi-person-fill"></i>
                    <span>{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Search journal form --}}
            <div class="col-md-3">
                <ul>
                    <li>
                        <form action="{{ route('admin-content.search') }}" method="POST">
                            @csrf
                            <label for="">Search by Journal Title</label>
                            <div class="search-input-group flex m-bot">
                                <input type="text" name="searchByTitle" placeholder="Journal Title">
                                <button type="submit" name="submit" class="searchBtn" title="Search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
        
                            <label for="">Search by Author Name</label>
                            <div class="search-input-group flex">
                                <input type="text" name="searchByAuthor" placeholder="Author Name">
                                <button type="submit" name="submit" class="searchBtn" title="Search">
                                    <i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </li>
    
                    <li style="margin-top: auto">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-door-closed-fill" style="margin-left: 0.5rem"></i>
                            {{ __('Logout') }}
                        </a>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            {{-- Journals container area --}}
            <div class="col-md-9">
                <div>
                    <div class="relative">
                        <h2><strong>{{ $journal->title }}</strong></h2>
                        <!-- Delete button -->
                        <div class="right-pos-absolute">
                            <form action="{{ route('admin-content.delete', ['id' => $journal->id]) }}"
                                method="POST" class="pos-right-m">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-delete flex" title="Delete Journal"
                                    onclick="return confirm('Are you sure you want to delete this journal?')">
                                    <span>Delete</span>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <p style="font-size: 1.25rem; color: var(--positive-color)">{{ $journal->author }}</p>
                    <p class="m-bot">Published by:
                        <strong>{{ $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}</strong>
                    </p>
                    <p class="m-bot">{{ $journal->abstract }}</p>
                    {{-- Download file --}}
                    <div class="flex gap-1">
                        <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}" class="link-download" style="border-right: 1px solid #0D0C0B; padding-right: 0.5rem; margin-right: 0.5rem">
                            <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                            Download File
                        </a>
                        <span style="border-right: 1px solid #0D0C0B; padding-right: 0.5rem; margin-right: 0.5rem">{{ $journal->journalDownloadCounter }} Downloads</span>
                        <span>{{ $journal->journalViewCounter }} Views</span>
                        {{-- <span># Downloads</span>
                        <span># Views</span> --}}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
@endsection
