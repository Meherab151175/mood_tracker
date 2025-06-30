@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">My Mood Journal</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moodEntryModal">
                Add New Entry
            </button>
        </div>
        <div class="card-body">
            @if ($moods->isEmpty())
                <div class="text-center py-5">
                    <h4>No mood entries yet</h4>
                    <p>Start tracking your mood by adding your first entry!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Mood</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moods as $mood)
                                <tr>
                                    <td>{{ $mood->date->format('Y-m-d') }}</td>
                                    <td>
                                        @switch($mood->mood_type)
                                            @case('happy')
                                                😊 Happy
                                            @break

                                            @case('neutral')
                                                😐 Neutral
                                            @break

                                            @case('sad')
                                                😢 Sad
                                            @break
                                        @endswitch
                                    </td>
                                    <td>{{ $mood->note ?: 'No note' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editMoodModal{{ $mood->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('moods.destroy', $mood) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this entry?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $moods->links() }}
            @endif
        </div>
    </div>

    @foreach ($moods as $mood)
        <!-- Edit Mood Modal -->
        <div class="modal fade" id="editMoodModal{{ $mood->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Mood Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('moods.update', $mood) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Select Mood</label>
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mood_type" value="happy"
                                            {{ $mood->mood_type === 'happy' ? 'checked' : '' }}>
                                        <label class="form-check-label">😊 Happy</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mood_type" value="neutral"
                                            {{ $mood->mood_type === 'neutral' ? 'checked' : '' }}>
                                        <label class="form-check-label">😐 Neutral</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mood_type" value="sad"
                                            {{ $mood->mood_type === 'sad' ? 'checked' : '' }}>
                                        <label class="form-check-label">😢 Sad</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Note (optional)</label>
                                <textarea class="form-control" name="note" rows="3">{{ $mood->note }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Mood</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
