<table class="table">
    <tr><th></th><th>Neurotici</th><th>Závislí</th><th>Celkem</th></tr>
    @foreach($overview as $row)
        <tr>
            <td>{{ $row['name'] }}</td>
            <td>{{ $row['neurotics'] }}</td>
            <td>{{ $row['adicts'] }}</td>
            <td>{{ $row['count'] }}</td>
            <td>{{ $row['neurotics'] + $row['adicts'] }}</td>
        </tr>
    @endforeach
</table>
