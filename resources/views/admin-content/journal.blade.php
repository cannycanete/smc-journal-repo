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
                {{-- Alert Message for uploading journal --}}
                @if (session('success'))
                    <div class="custom-alert m-bot" role="alert">
                        <span>Success! Journal Updated</span>
                    </div>
                @endif

                {{-- APRPOVED JOURNALS --}}
                @if ($journal->approval == 'approved')
                    <div>
                        <div class="flex" style="gap: 1rem">
                            <h2><strong>{{ $journal->title }}</strong></h2>
                            <a href="{{ route('admin-content.edit', ['id' => $journal->id]) }}" class="edit-btn right-pos-m"
                                style="display: flex; gap: 0.5rem">
                                <i class="bi bi-pen"></i>
                                <span>Edit</span>
                            </a>

                            <!-- Delete button -->
                            <div class="">
                                <form action="{{ route('admin-content.delete', ['id' => $journal->id]) }}" method="POST"
                                    class="pos-right-m">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-delete flex" title="Delete Journal"
                                        style="display: flex; gap: 0.5rem"
                                        onclick="return confirm('Are you sure you want to delete this journal?')">
                                        <i class="bi bi-x-lg"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p style="font-size: 1.25rem; color: var(--positive-color)">{{ $journal->author }}</p>
                        <p class="m-bot">Published by:
                            <strong>{{ $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}</strong>
                        </p>

                        {{-- Author img container --}}
                        <div class="flex m-bot" style="gap: 0.5rem">
                            <div class="img-container">
                                <img src="/{{ $journal->authorImage }}" alt="" style="width: 100%">
                            </div>
                            <div class="img-container">
                                <img src="/{{ $journal->coAuthorImage }}" alt="" style="width: 100%">
                            </div>
                        </div>
                        <p class="m-bot">{{ $journal->abstract }}</p>

                        {{-- Download file --}}
                        <div class="flex gap-1">
                            <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}"
                                class="link-download"
                                style="border-right: 1px solid #0D0C0B; padding-right: 0.5rem; margin-right: 0.5rem">
                                <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                                Download File
                            </a>
                            <span
                                style="border-right: 1px solid #0D0C0B; padding-right: 0.5rem; margin-right: 0.5rem">{{ $journal->journalDownloadCounter }}
                                Downloads</span>
                            <span>{{ $journal->journalViewCounter }} Views</span>
                            
                        </div>

                    </div>

                    {{-- PENDING JOURNALS --}}
                @elseif ($journal->approval == 'pending')
                    <div>
                        <h2><strong>{{ $journal->title }}</strong></h2>

                        <p style="font-size: 1.25rem; color: var(--positive-color)">{{ $journal->author }}</p>
                        <p class="m-bot">Published by:
                            <strong>{{ $journal->publisher . ' - ' . \Carbon\Carbon::parse($journal->datePublished)->format('F d, Y') }}</strong>
                        </p>
                        <p class="m-bot">{{ $journal->abstract }}</p>

                        {{-- Download file --}}
                        <div class="flex gap-1">
                            <a href="{{ asset($journal->filePath) }}" download="{{ $journal->fileName }}"
                                class="link-download">
                                <i class="bi bi-cloud-arrow-down-fill" style="margin-right: 0.5rem"></i>
                                Download File
                            </a>
                        </div>

                        {{-- Must check before approve --}}
                        <p class="m-top m-bot"><strong>Must have already submmited the following:</strong></p>
                        <div class="flex" style="gap: 1rem">
                            <div class="checkbox-container">
                                <label for="cd">CD</label>
                                <input type="checkbox" class="requirement-checkbox" name="cd" id="cd">
                            </div>

                            <div class="checkbox-container">
                                <label for="article">Article</label>
                                <input type="checkbox" class="requirement-checkbox" name="article" id="article">
                            </div>

                            <div class="checkbox-container">
                                <label for="hardbound">Hardbound</label>
                                <input type="checkbox" class="requirement-checkbox" name="hardbound" id="hardbound">
                            </div>

                            {{-- Approve --}}
                            <div class="right-pos-m">
                                <a href="{{ route('admin-content.approve', ['id' => $journal->id]) }}"
                                    class="approve-btn disabled" id="approveBtn" style="display: flex; gap: 0.5rem">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Approve</span>
                                </a>
                            </div>

                            <!-- Delete button -->
                            <div style="width: fit-content">
                                <form action="{{ route('admin-content.delete', ['id' => $journal->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-delete flex" title="Delete Journal"
                                        style="display: flex; gap: 0.5rem"
                                        onclick="return confirm('Are you sure you want to delete this journal?')">
                                        <i class="bi bi-x-lg"></i>
                                        <span>Remove</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- Dissable approve-btn so long as the requirements are not met --}}
    <script>
        $(document).ready(function() {
            // Function to check if all checkboxes are checked
            function areCheckboxesChecked() {
                return $('#cd').prop('checked') && $('#article').prop('checked') && $('#hardbound').prop('checked');
            }

            // Update approve button state on checkbox change
            $('.requirement-checkbox').change(function() {
                if (areCheckboxesChecked()) {
                    $('#approveBtn').removeClass('disabled');
                } else {
                    $('#approveBtn').addClass('disabled');
                }
            });

            // Handle approve button click
            $('#approveBtn').click(function(event) {
                if ($(this).hasClass('disabled')) {
                    event.preventDefault(); // Prevent the default click behavior
                    // Optionally, you can provide some visual feedback that the button is disabled (e.g., display a message)
                    console.log("Please check all checkboxes before approving.");
                }
                // Continue with the default click behavior if not disabled
            });

            // Initial check on page load
            if (areCheckboxesChecked()) {
                $('#approveBtn').removeClass('disabled');
            }
        });
    </script>

@endsection
