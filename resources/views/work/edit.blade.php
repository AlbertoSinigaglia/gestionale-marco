@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <p class="d-block w-100 h4 pt-0 font-weight-bold">Modifica lavoro</p>
                            <form class="w-100 pb-3" action="{{route('work.update', ['work' => $work->id])}}" method="POST">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <label for="date">Data del lavoro:</label>
                                        <input type="date" required class="form-control" id="date" name="day" placeholder="Inserisci data del lavoro" value="{{old('day') ?? $work->day->format('Y-m-d') ?? today('Europe/Rome')->format('Y-m-d')}}">
                                    </div>
                                    <div class="col">
                                        <label for="workers">Numero lavoratori:</label>
                                        <input type="number" required step="1" min="1" class="form-control" name="number_of_workers" id="workers" placeholder="Inserisci numero di lavoratori" value="{{old('number_of_workers') ?? $work->number_of_workers ?? 1}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="begin-time">Ora di inizio:</label>
                                        <input type="time" required class="form-control" name="begin_at" value="{{old('begin_at') ?? $work->begin_at->format('H:i')}}" id="begin-time" placeholder="Inserisci l'ora di inizio">
                                    </div>
                                    <div class="col">
                                        <label for="finish-time">Ora di fine:</label>
                                        <input type="time" required class="form-control" name="finish_at" value="{{old('finish_at') ?? $work->finish_at->format('H:i')}}" id="finish-time" placeholder="Inserisci l'ora di fine">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="disposal">Smaltimento:</label>
                                        <input type="number" step="0.01" min="0" required class="form-control" name="disposal" value="{{old('disposal') ?? $work->disposal ?? '0'}}" id="disposal" placeholder="Inserisci il costo dello smaltimento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="description">Descrizione:</label>
                                        <textarea class="form-control" name="description" id="description">{{old('description') ?? $work->description}}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="machines" name="machines" {{old('machines') ?? $work->machines ? 'checked' : ''}}>
                                            <label class="form-check-label" for="machines">
                                                Usato macchine
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="paid" name="paid" {{old('paid')  ?? $work->paid ? 'checked' : ''}}>
                                            <label class="form-check-label" for="paid">
                                                Già pagato
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3">Aggiorna</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
