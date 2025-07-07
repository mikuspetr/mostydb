<table class="table">
    <tr><th></th><th>Neurotici</th><th>Závislí</th><th>Celkem</th></tr>
    @foreach($overview as $key => $row)
        <tr>
            <td>{{ $row['name'] }}</td>
            <td>{{ $row['neurotics'] }}</td>
            <td>{{ $row['adicts'] }}</td>
            <td>{{ $row['neurotics'] + $row['adicts'] }} 
                @if($key === 'contacts-pp' && isset($all) && $all)
                    (cíl 583)
                @endif
            </td>
        </tr>
    @endforeach
</table>
