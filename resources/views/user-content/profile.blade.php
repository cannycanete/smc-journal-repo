@extends('layout')

@section('content')
    <div class="main main-expanded">

        <div class="row m-bot flex">
            <div class="col-md-3">
                <a href="{{ route('user-content.index') }}" class="text-nav-title">SMC Research Journal Online Repository</a>
            </div>

            <div class="col-md-9 flex">
                <p class="text-nav-title">Your Upladed Journals</p>
                <a href="{{ route('user-content.create') }}" class="link-btn right-pos-m">
                    <i class="bi bi-cloud-arrow-up-fill" style="margin-right: 0.5rem"></i>
                    Upload Journal
                </a>
            </div>
        </div>

        <div class="row">
            {{-- User info & upload journal link --}}
            <div class="col-md-3">
                <ul>
                    <li>
                        <p class="text-nav-title">{{ Auth::user()->name }}</p>
                        <p class="m-bot">{{ Auth::user()->email }}</p>
                    </li>

                    <li>
                        <p>Joined on:</p>
                        <span>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('F d, Y') }}</span>
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

            {{-- User uploaded journals --}}
            <div class="col-md-9">
                {{-- Alert Message for uploading journal --}}
                @if (session('success'))
                    <div class="custom-alert m-bot" role="alert">
                        <span>Success! Journal Uploaded</span>
                    </div>
                @elseif (session('success-delete'))
                    <div class="custom-alert delete m-bot" role="alert">
                        <span>Success! Journal Deleted</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="custom-alert delete m-bot" role="alert">
                        <strong style="color:#fff">Error</strong>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="journal-card-container">
                    {{-- All journals loop here --}}
                    <div class="journal-card-container">
                        @if ($journals->isEmpty())
                            <p>You have no journals yet.</p>
                        @else
                            @foreach ($journals as $journal)
                                <div class="journal-card">
                                    <div class="relative">
                                        <a class="text-journal-title text-bold"
                                            href="{{ route('user-content.journal', ['id' => $journal->id]) }}">{{ $journal->title }}</a>
                                        <!-- Delete button -->
                                        <div class="right-pos-absolute">
                                            <form action="{{ route('user-content.delete', ['id' => $journal->id]) }}"
                                                method="POST" class="pos-right-m">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-delete" title="Delete Journal"
                                                    onclick="return confirm('Are you sure you want to delete this journal?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                    <span class="text-journal-basic-info">
                                        {{ $journal->author . ' - ' . $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}
                                    </span>
                                    <p class="text-cutoff">{{ $journal->abstract }}</p>
                                    {{-- Download file --}}
                                    <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}"
                                        class="link-download">
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
    </div>

    {{-- SCRIPTS --}}
@endsection
