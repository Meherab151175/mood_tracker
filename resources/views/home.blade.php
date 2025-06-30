@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Track Your Daily Moods</h1>
            <p class="lead mb-4">Keep track of your emotional well-being and discover patterns in your mood over time.</p>

            @auth
                <button class="btn btn-primary btn-lg mb-4" data-bs-toggle="modal" data-bs-target="#moodEntryModal">
                    Record Today's Mood
                </button>

                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Current Streak</h5>
                                <p class="display-4">{{ Auth::user()->currentStreak() }}</p>
                                <p class="card-text">days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Entries</h5>
                                <p class="display-4">{{ Auth::user()->moods()->count() }}</p>
                                <p class="card-text">moods recorded</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Most Common Mood</h5>
                                <p class="display-4">
                                    @switch(Auth::user()->moods()->select('mood_type')->groupBy('mood_type')->orderByRaw('COUNT(*)
                                        DESC')->first()?->mood_type)
                                        @case('happy')
                                            😊
                                        @break

                                        @case('neutral')
                                            😐
                                        @break

                                        @case('sad')
                                            😢
                                        @break

                                        @default
                                            -
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
