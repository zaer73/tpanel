@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th>line</th>
			<th>condition type</th>
			<th>condition text</th>
			<th>reaction</th>
			<th>reaction text</th>
			<th>group</th>
			<th>edit</th>
			<th>enable/disable</th>
		</tr>
	@foreach($codereaders as $codereader)
		<tr>
			<td>
				{{ $codereader->title }}
			</td>
			<td>
				@if($codereader->line)
					{{ $codereader->line->number }}
				@endif
			</td>
			<td>
				{{ condition_type($codereader->condition_type) }}
			</td>
			<td>
				{{ $codereader->condition_text }}
			</td>
			<td>
				{{ reaction_type($codereader->reaction_type) }}
			</td>
			<td>
				{{ $codereader->reaction_text }}
			</td>
			<td>
				@if($codereader->group)
					{{ $codereader->group->title }}
				@endif
			</td>
			<td>
				<a href="{{ route('codereaders.edit', ['id' => $codereader->id]) }}">
					edit
				</a>
			</td>
			<td>
				@if($codereader->status == 0)
				<form method="post" action="{{ route('codereaders.destroy', ['id' => $codereader->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">disable</button>
				</form>
				@else 
				<form method="post" action="{{ route('codereaders.enable', ['id' => $codereader->id]) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<button type="submit">enable</button>
				</form>
				@endif
			</td>
		</tr>
	@endforeach
	</table>
@stop