@extends('layout')

@section('content')
    <div class="main main-expanded">
        <div class="row m-bot flex">
            <div class="col-md-3">
                <a href="{{ route('user-content.index') }}" class="nav-title-container flex">
                    <img src="{{ asset('img/mysmc.png') }}" alt="mysmclogo" class="img-nav-logo">
                    <p class="nav-sub-text">Research Office Online Repository</p>
                </a>
            </div>

            <div class="col-md-9">
                <p class="text-nav-title">
                    <a href="{{ route('user-content.profile') }}" style="font-weight: nomal">
                        <i class="bi bi-caret-left-fill" style="margin-right: 0.25rem"></i>{{ Auth::user()->name }}
                    </a>
                    / Upload Article
                </p>
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

            {{-- Upload journal form --}}
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

                <form action="{{ route('user-content.upload') }}" method="POST" enctype="multipart/form-data">
                    @method('post')

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Research Title</label>
                                <input type="text" name="title" id="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Author, Co-Author</label>
                                <input type="text" name="author" id="author" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Publisher</label>
                                <input type="text" name="publisher" id="publisher" value="Research Office" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input-group">
                                <label for="">Date Published</label>
                                <input type="date" name="datePublished" id="datePublished" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-input-group">
                                <label>Abstract</label>
                                <textarea name="abstract" class="m-bot" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="journalFile" class="form-label">Article File</label>
                            <input class="form-control" type="file" name="journalFile" id="journalFile"
                                style="box-shadow: none" required>
                        </div>
                        <div class="row col-md-8">
                            <div class="col-md-6">
                                <label for="authorImage" class="form-label">Author Image</label>
                                <input class="form-control" type="file" name="authorImage" id="authorImage"
                                    style="box-shadow: none" required accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="coAuthorImage" class="form-label">Co-Author Image</label>
                                <input class="form-control" type="file" name="coAuthorImage" id="coAuthorImage"
                                    style="box-shadow: none" required accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12 flex flex-gap-1">
                            <div class="right-pos-m">
                                <label for=""></label>
                                <button type="submit" class="link-btn" name="submit">
                                    <i class="bi bi-cloud-arrow-up-fill" style="margin-right: 0.5rem"></i>
                                    Upload Article
                                </button>
                            </div>
                            <div>
                                <label for=""></label>
                                <a href="{{ route('user-content.profile') }}" class="link-cancel"><i class="bi bi-x-lg"
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
