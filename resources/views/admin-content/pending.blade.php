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

            <div class="col-md-9">
                <div class="flex">
                    <div>
                        {{-- Display search info --}}
                        @if ($title !== null || $author !== null)
                            @if ($title !== '' && $author === null)
                                <p>Showing results for <strong>{{ $title }}</strong></p>
                            @elseif ($author !== '' && $title === null)
                                <p>Showing results for <strong>{{ $author }}</strong></p>
                            @elseif ($title === '' && $author === null)
                                <p>No journals found for <strong>{{ $title }}</strong> by
                                    <strong>{{ $author }}</strong>
                                </p>
                            @elseif ($title !== '' && $author !== '')
                                <p>Showing results for <strong>{{ $title }}</strong> and
                                    <strong>{{ $author }}</strong>
                                </p>
                            @endif
                        @endif
                    </div>

                    <div class="flex right-pos-m" style="gap: 0.5rem">
                        <i class="bi bi-person-fill"></i>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
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
                                <input type="text" name="searchByTitle" placeholder="Journal Title" value="{{ $title }}">
                                <button type="submit" name="submit" class="searchBtn" title="Search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
        
                            <label for="">Search by Author Name</label>
                            <div class="search-input-group flex">
                                <input type="text" name="searchByAuthor" placeholder="Author Name" value="{{ $author }}">
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
                <div class="flex m-bot" style="gap: 0.5rem">
                    <a href="{{ route('admin-content.index') }}" class="nav-approval">Approved</a>
                    <a href="{{ route('admin-content.pending') }}" class="nav-approval active">Pending</a>
                </div>

                <div class="journal-card-container">
                    @if ($journals->isEmpty())
                        <p>No journals yet</p>
                    @else
                        @foreach ($journals as $journal)
                            <div class="journal-card">
                                <div class="flex">
                                    <a href="{{ route('admin-content.profile', ['user_id' => $journal->user_id]) }}" class="text-bold" style="border-right: 1px solid #0D0C0B; padding-right: 0.5rem; margin-right: 0.5rem">{{ $journal->user->name }}</a>
                                    <a class="text-journal-title text-bold"
                                    href="{{ route('admin-content.journal', ['id' => $journal->id]) }}">{{ $journal->title }}</a>
                                </div>
                                
                                <span class="text-journal-basic-info">
                                    {{ $journal->author . ' - ' . $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}
                                </span>
                                <p class="text-cutoff">{{ $journal->abstract }}</p>
                                <div class="flex gap-1">
                                    {{-- Download file --}}
                                    <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}"
                                        class="link-download">
                                        <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
@endsection