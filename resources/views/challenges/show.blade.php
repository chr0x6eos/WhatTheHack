<html>
<body>
    <h2>Challenge details</h2>
    <p>
        <strong>ID:</strong>
        {{ $challenge->id }}
    </p>
    <p>
        <strong>Name:</strong>
        {{ $challenge->name }}
    </p>
    <p>
        <strong>Description:</strong>
        <br>
        {{ $challenge->description }}
    </p>
    <p>
        <strong>Difficulty:</strong>
        {{ $challenge->difficulty }}
    </p>
    <p>
        <strong>Author:</strong>
        {{ $challenge->author }}
    </p>
    <p>
        <strong>Docker-Image-ID:</strong>
        {{ $challenge->imageID }}
    </p>
    <p>
        <strong>Attachments:</strong>
        <br>
        {{ $challenge->attachments }}
    </p>
    <a href="{{ route('challenges.edit', $challenge->id) }}">Edit</a><br>
    <form method="POST" action="{{ route('challenges.delete',$challenge->id) }}">
    @csrf
        @method('delete')
        <button type="submit">Delete</button>
    </form>
    <a href="{{ route('challenges.index') }}">Go back</a>
</body>
</html>
