<html>
<body>
<h2>Challenges</h2>
<table border="1">
<thead>
<th>Id</th>
<th>Name</th>
<th>Difficulty</th>
<th>Author</th>
<th colspan="1">Actions</th>
</thead>
<tbody>
    @foreach($challenges as $challenge)
    <tr>
        <td>{{ $challenge->id }}</td>
        <td>{{ $challenge->name }}</td>
        <td>{{ $challenge->difficulty }}</td>
        <td>{{ $challenge->author }}</td>
        <td>
            <a href="{{ route('challenges.show', $challenge->id) }}">More info</a>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
<br>
<a href="{{route('challenges.create')}}">Add new challenge</a>
</body>
</html>
