@extends('layout')

@section('content')
{{ $table }}
<div class="canvas-container-container">
    <div class="canvas-container" style="width:{{ $width }}px;">
        <canvas id="canvas-found" width="{{ $width }}" height="{{ $height }}"></canvas>
    </div>
</div>
<div class="canvas-container-container">
    <div class="canvas-container" style="width:{{ $width }}px;">
        <canvas id="canvas" width="{{ $width }}" height="{{ $height }}"></canvas>
    </div>
</div>

<div class="words-list center-block round">
    @foreach($words as $word)
    <span id="{{ $word }}" data-todo="1">{{ $word }}</span>
    @endforeach
</div>

<div class="center-block" id="size-form">
    <form method="post" action="" >
        {{ Form::token() }}
        <div>
            <label for="rows-slider">Aantal rijen</label>
            <input name="rows" value="" class="slider" id="rows-slider" data-slider-id="rows-slider" type="text" data-slider-min="5" data-slider-max="15" data-slider-step="1" data-slider-value="{{ $sliderRowValue }}" />
        </div>
        <div>
            <label for="cols-slider">Aantal kolommen</label>
            <input name="cols" value="" class="slider" id="cols-slider" data-slider-id="cols-slider" type="text" data-slider-min="5" data-slider-max="15" data-slider-step="1" data-slider-value="{{ $sliderColValue }}" />
        </div>
        <div>
            <label for="size-submit">&nbsp;</label>
            <input id="size-submit" type="submit" value="Maak een nieuwe!" />
        </div>
    </form>
</div>

<img id="hoera-image" src="img/hoera.jpg" alt="HOERA" style="position:absolute; top:0; left:0; display:none;">
@stop
