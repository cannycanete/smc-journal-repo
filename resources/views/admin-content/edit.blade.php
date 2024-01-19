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
                <h2>Update: <strong>{{ $journal->title }}</strong></h2>
                <div class="flex right-pos-m" style="gap: 0.5rem">
                    <i class="bi bi-person-fill"></i>
                    <span>{{ Auth::user()->email }}</span>
                </div>
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

            {{-- EDIT journal form --}}
            <div class="col-md-9">
                {{-- Error Messages goes here --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin-content.update', ['id' => $journal->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Journal Title</label>
                                <input type="text" name="title" id="title" required value="{{ $journal->title }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Journal Author</label>
                                <input type="text" name="author" id="author" required value="{{ $journal->author }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Publisher</label>
                                <input type="text" name="publisher" id="publisher" required value="{{ $journal->publisher }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Date Published</label>
                                <input type="date" name="datePublished" id="datePublished" required value="{{ $journal->datePublished }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-input-group">
                                <label>Abstract</label>
                                <textarea name="abstract" class="m-bot" required>{{ $journal->abstract }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 flex flex-gap-1">
                            <div class="">
                                <button type="submit" class="link-btn" name="submit">
                                    <i class="bi bi-cloud-arrow-up-fill" style="margin-right: 0.5rem"></i>
                                    Save
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('admin-content.journal', ['id' => $journal->id]) }}" class="link-cancel"><i class="bi bi-x-lg"
                                        style="margin-right: 0.5rem"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
@endsection
