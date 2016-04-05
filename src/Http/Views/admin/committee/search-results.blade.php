@foreach($searchresults as $result)
<tr>
  <td>{{ $result->first_name }}</td>
  <td>{{ $result->last_name }}</td>
  <td><a href="#"><span class="glyphicon glyphicon-plus"></span></a></td>
</tr>
@endforeach