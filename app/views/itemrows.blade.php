@if(count($items) > 0)
	@foreach($items as $item)
	<div class="row item-row" data-id="{{ $item->id }}">
		<div class="col-sm-8 col-xs-7">{{ $item->title }}</div>
		<div class="col-xs-3">{{ $item->due }}</div>
		<div class="col-sm-1 col-xs-2">
			<input type="radio" class="inrow @if($item->status == 0)radio-false @endif" checked readonly /><label><span><span></span></span></label></div>
	</div>
	@endforeach
@else
<div class="row empty-row">
	<div class="col-xs-12">No Items to Show!</div>
</div>
@endif