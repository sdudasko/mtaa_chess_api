<style type="text/css">
    /* http://meyerweb.com/eric/tools/css/reset/
   v2.0 | 20110126
   License: none (public domain)
*/

    body {
        font-family: sans-serif;
        font-size: 12pt;
    }

    table {
        border-collapse: collapse;
        border-spacing: 2px 0;
        margin: 2px 0;
        padding: 2px 0;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

</style>

<h2>
    Results after round {{ $matches->first()->round }}
</h2>
<table style="border: 1px solid black; width: 100%" class="table table-striped">
    <tbody style="width: 100%">
    <tr>
        <th style="text-align: center;">No.</th>
        <th style="text-align: left">White</th>
        <th style="text-align: left">Black</th>
        <th style="text-align: center">Result</th>
    </tr>
    @foreach($matches as $index => $match)
        <tr style="margin: 0; padding: 0; border: 1px solid black; width: 100%;">
            <td style="padding: 0; margin: 0; width: 14%; text-align: center">{{ $index + 1}}</td>
            <td style="padding: 0; margin: 0; width: 38%; text-align: left">{{ $match->whitePlayer->name . ' (' .$match->whitePlayer->elo .')' }}</td>
            <td style="padding: 0; margin: 0; width: 38%; text-align: left">{{ $match->blackPlayer->name . ' (' .$match->blackPlayer->elo .')' }}</td>
            <td style="padding: 0; margin: 0; width: 10%; text-align: center">{{ $match->getFromattedResult() }}</td>
        </tr>
    @endforeach
    </tbody>

</table>