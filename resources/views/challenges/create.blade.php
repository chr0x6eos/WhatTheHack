<html>
<body>
<h2>Add a new challenge</h2>
    <form method="post" action="{{ route('challenges.store') }}" id="challengeform">
    @csrf
        <p>
            <strong>Challenge name:</strong>
            <input type="text" name="name">
        </p>
        <p>
            <strong>Challenge description:</strong>
            <textarea form="challengeform" name="description">
            </textarea>
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
            <input type="text" name="author">
        </p>
        <p>
            <strong>Docker Image ID: (optional)</strong>
            <input type="text" name="imageID">
        </p>
        <p>
            <strong>Attachments</strong>
            <input type="text" name="attachments">
        </p>
        <p>
            <button type="submit">Submit</button>
        </p>
    </form>
</body>
</html>
