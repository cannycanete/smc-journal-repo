@extends('layout')

@section('content')
    <div class="main main-expanded">
        <div class="row m-bot flex">
            <div class="col-md-3">
                <a href="{{ route('user-content.index') }}" class="text-nav-title">SMC Research Journal Online Repository</a>
            </div>

            <div class="col-md-9">
                <div class="flex">
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
            </div>
            {{-- Journals container area --}}
            <div class="col-md-9">
                <div>
                    <h2><strong>{{ $journal->title }}</strong></h2>
                    <p style="font-size: 1.25rem; color: var(--positive-color)">{{ $journal->author }}</p>
                    <p  class="m-bot">Published by: <strong>{{$journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}</strong></p>
                    <p class="m-bot">{{ $journal->abstract }}</p>
                    {{-- Download file --}}
                    <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}"
                        class="link-download">
                        <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                        Download File
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
@endsection
