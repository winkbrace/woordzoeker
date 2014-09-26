@extends('layout')

@section('content')
{{ $table }}

<div class="words-list center-block round">
    {{ implode(', ', $words) }}
</div>

<div class="center-block" id="size-form">
    <form method="post" action="" >
        {{ Form::token() }}
        <div>
            <label for="rows-slider">Aantal rijen</label>
            <input name="rows" value="" class="slider" id="rows-slider" data-slider-id="rows-slider" type="text" data-slider-min="5" data-slider-max="20" data-slider-step="1" data-slider-value="{{ $sliderRowValue }}" />
        </div>
        <div>
            <label for="cols-slider">Aantal kolommen</label>
            <input name="cols" value="" class="slider" id="cols-slider" data-slider-id="cols-slider" type="text" data-slider-min="5" data-slider-max="20" data-slider-step="1" data-slider-value="{{ $sliderColValue }}" />
        </div>
        <div>
            <label for="size-submit">&nbsp;</label>
            <input id="size-submit" type="submit" value="Maak een nieuwe!" />
        </div>
    </form>
</div>
@stop
