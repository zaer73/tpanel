@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_news_all') }}</h2>
	<table>
		<tr>
			<th>title</th>
			<th>create at</th>
			<th>edit</th>
		</tr>
		@foreach($news as $new)
		<tr>
			<td>{{ $new->title }}</td>
			<td>{{ jalali($new->created_at) }}</td>
			<td><a href="{{ route('news.edit', ['id' => $new->id]) }}">edit</a></td>
		</tr>
		@endforeach
	</table>
@stop