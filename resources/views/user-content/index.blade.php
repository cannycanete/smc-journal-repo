@extends('layout')

@section('content')
    <div class="main main-expanded">
        <div class="row m-bot flex">
            <div class="col-md-3">
                <a href="{{ route('user-content.index') }}" class="nav-title-container flex">
                    {{-- <p class="nav-main-text">SMC</p> --}}
                    <img src="img/mysmc.png" alt="mysmclogo" class="img-nav-logo">
                    <p class="nav-sub-text">Research Journal Online Repository</p>
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

                    <a href="{{ route('user-content.profile') }}" class="flex right-pos-m" style="gap: 0.5rem">
                        <i class="bi bi-person-fill"></i>
                        <span>{{ Auth::user()->email }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Search journal form --}}
            <div class="col-md-3">
                <form action="{{ route('user-content.search') }}" method="POST">
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
            </div>
            {{-- Journals container area --}}
            <div class="col-md-9">
                <div class="journal-card-container">
                    @if ($journals->isEmpty())
                        <p>No journals yet</p>
                    @else
                        @foreach ($journals as $journal)
                            <div class="journal-card">
                                <a class="text-journal-title text-bold"
                                    href="{{ route('user-content.journal', ['id' => $journal->id]) }}">{{ $journal->title }}</a>
                                <span class="text-journal-basic-info">
                                    {{ $journal->author . ' - ' . $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}
                                </span>
                                <p class="text-cutoff">{{ $journal->abstract }}</p>
                                {{-- Download file --}}
                                <a href="{{ route('download-journal', ['id' => $journal->id]) }}" class="link-download">
                                    <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                                    Download File
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
@endsection
