<html>
<body>
<h2>Edit {{ $challenge->name }}</h2>
<form method="post" action="{{ route('challenges.update', $challenge)}}" id="challengeform">
    @csrf
    @method('patch')
    <p>
        <strong>Challenge name:</strong>
        <input type="text" name="name" value="{{ $challenge->name }}">
    </p>
    <p>
        <strong>Challenge description:</strong>
        <br>
        <textarea form="challengeform" name="description">{{ $challenge->description }}</textarea>
    </p>
    <p>
        <strong>Difficulty</strong>
        <select name="difficulty">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </p>
    <p>
        <strong>Author</strong>
        <input type="text" name="author" value="{{ $challenge->author }}">
    </p>
    <p>
        <strong>Docker Image ID (optional)</strong>
        <input type="text" name="imageID" value="{{ $challenge->imageID }}">
    </p>
    <p>
        <strong>Attachments (optional)</strong>
        <input type="text" name="attachments" value="{{ $challenge->attachments }}">
    </p>
    <p>
        <button type="submit">Update</button>
    </p>
    <p>
    @if($errors)
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
            @endif
    </p>
</form>
</body>
</html>
