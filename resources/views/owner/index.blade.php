<h1>Owners</h1>

<a href="{{ route('owners.create') }}">Add Owner</a>

@foreach($owners as $owner)
    <p>
        {{ $owner->full_name }} |
        {{ $owner->contact_number }} |
        {{ $owner->address }}
    </p>
@endforeach