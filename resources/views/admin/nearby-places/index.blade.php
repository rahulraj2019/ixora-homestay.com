@extends('admin.layouts.app')
@section('title', 'Nearby places')
@section('subtitle', 'Road distance and drive time shown on Explore / Home')

@section('content')
<div class="toolbar toolbar--split">
    <p class="toolbar__hint">Values are approximate from IXORA Niduvaloor Gate. Save to override the config defaults.</p>
    <a class="btn line" href="{{ route('page.show', 'explore') }}" target="_blank" rel="noopener">View Explore ↗</a>
</div>

<form method="POST" action="{{ route('admin.nearby-places.update') }}" class="panel nearby-form">
    @csrf
    @method('PUT')

    <div class="nearby-list">
        @foreach($places as $i => $place)
            <article class="nearby-card{{ $place['has_override'] ? ' is-custom' : '' }}">
                <header class="nearby-card__head">
                    <div>
                        <h3>{{ $place['title'] }}</h3>
                        <p class="nearby-card__meta">{{ $place['type'] }} · {{ $place['direction'] }}</p>
                    </div>
                    @if($place['has_override'])
                        <span class="badge">custom</span>
                    @endif
                </header>

                <input type="hidden" name="places[{{ $i }}][title]" value="{{ $place['title'] }}">

                <div class="nearby-card__fields">
                    <div>
                        <label for="distance-{{ $i }}">Distance (km)</label>
                        <input
                            id="distance-{{ $i }}"
                            type="number"
                            name="places[{{ $i }}][distance_km]"
                            value="{{ old('places.'.$i.'.distance_km', $place['distance_km']) }}"
                            min="0"
                            max="500"
                            step="0.1"
                            inputmode="decimal"
                            required
                        >
                    </div>
                    <div>
                        <label for="drive-{{ $i }}">Drive time (min)</label>
                        <input
                            id="drive-{{ $i }}"
                            type="number"
                            name="places[{{ $i }}][drive_mins]"
                            value="{{ old('places.'.$i.'.drive_mins', $place['drive_mins']) }}"
                            min="0"
                            max="600"
                            inputmode="numeric"
                            required
                        >
                    </div>
                </div>

                <p class="nearby-card__default">Config default: {{ $place['default_distance_km'] }} km · {{ $place['default_drive_mins'] }} min</p>
            </article>
        @endforeach
    </div>

    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save distances</button>
        <span class="muted">Saving the config defaults clears a custom override.</span>
    </div>
</form>
@endsection
