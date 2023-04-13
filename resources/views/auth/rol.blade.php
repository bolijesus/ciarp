@extends('layouts.app')

@section('content')
<div class="card">
    <div class="body">
        <form class="form-horizontal" method="POST" action="{{ route('rol') }}">
            {{ csrf_field() }}
            <div class="input-group">
                <div class="form-line">
                    {!! Form::select('grupo',$grupos,null,['class'=>'form-control show-tick','placeholder'=>'-- Seleccione Rol Para Continuar --','required']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-block bg-pink waves-effect" type="submit">CONTIUAR</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection