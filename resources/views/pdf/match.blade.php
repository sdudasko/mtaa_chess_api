<table>
    <thead>
        {{ "Round " . $matches->first()->round }}
    </thead>

    <tbody>
        <th>No.</th>
        <th>White</th>
        <th>Black</th>
        <th>Result</th>
    </tbody>

    @foreach($matches as $index => $match)
        <td>{{ $index }}</td>
        <td>{{ $match->whitePlayer->name . '(' .$match->whitePlayer->elo .')' }}</td>
        <td>{{ $match->blackPlayer->name . '(' .$match->blackPlayer->elo .')' }}</td>
        <td>{{ $match->getResult() }}</td>
    @endforeach

</table>