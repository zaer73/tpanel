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
	@foreach($autoreplies as $autoreply)
		<tr>
			<td>
				{{ $autoreply->title }}
			</td>
			<td>
				@if($autoreply->line)
					{{ $autoreply->line->number }}
				@endif
			</td>
			<td>
				{{ condition_type($autoreply->condition_type) }}
			</td>
			<td>
				{{ $autoreply->condition_text }}
			</td>
			<td>
				{{ reaction_type($autoreply->reaction_type) }}
			</td>
			<td>
				{{ $autoreply->reaction_text }}
			</td>
			<td>
				@if($autoreply->group)
					{{ $autoreply->group->title }}
				@endif
			</td>
			<td>
				<a href="{{ route('autoreplies.edit', ['id' => $autoreply->id]) }}">
					edit
				</a>
			</td>
			<td>
				@if($autoreply->status == 0)
				<form method="post" action="{{ route('autoreplies.destroy', ['id' => $autoreply->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">disable</button>
				</form>
				@else 
				<form method="post" action="{{ route('autoreplies.enable', ['id' => $autoreply->id]) }}">
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