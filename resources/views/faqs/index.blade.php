@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>question</th>
			<th>answer</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($faqs as $faq)
		<tr>
			<td>{{ str_limit($faq->question, 200) }}</td>
			<td>{{ str_limit($faq->answer, 200) }}</td>
			<td>
				<a href="{{ route('faqs.edit', ['id' => $faq->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('faqs.destroy', ['id' => $faq->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop