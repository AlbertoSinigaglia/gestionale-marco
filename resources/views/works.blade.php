@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <h3 class="pb-3 border-bottom w-100 font-weight-bold">Totale per {{$client->name}}: <span class="font-weight-normal">€{{$client->amount}}</span></h3>
                            <p class="d-block w-100 h4 pt-5 font-weight-bold">Inserisci nuovo lavoro</p>
                            <form class="w-100 pb-3 border-bottom" action="{{route('work.create', ['client' => $client->id])}}" method="POST">
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
                                    <div class="col-md-6 col-sm-12">
                                        <label for="date">Data del lavoro:</label>
                                        <input  required type="date" class="form-control" id="date" name="day" placeholder="Inserisci data del lavoro" value="{{old('day') ?? today('Europe/Rome')->format('Y-m-d')}}">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="workers">Numero lavoratori:</label>
                                        <input required type="number" step="1" min="1" class="form-control" name="number_of_workers" id="workers" placeholder="Inserisci numero di lavoratori" value="{{old('number_of_workers') ?? 1}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="begin-time">Ora di inizio:</label>
                                        <input required type="time" class="form-control" name="begin_at" value="{{old('begin_at')}}" id="begin-time" placeholder="Inserisci l'ora di inizio">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="finish-time">Ora di fine:</label>
                                        <input required type="time" class="form-control" name="finish_at" value="{{old('finish_at')}}" id="finish-time" placeholder="Inserisci l'ora di fine">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="disposal">Smaltimento:</label>
                                        <input type="number" step="0.01" min="0" required class="form-control" name="disposal" value="{{old('disposal') ?? '0'}}" id="disposal" placeholder="Inserisci il costo dello smaltimento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="description">Descrizione:</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="Inserisci la descizione">{{old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="machines" name="machines" {{old('machines') ? 'checked' : ''}}>
                                            <label class="form-check-label" for="machines">
                                                Usato macchine
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="paid" name="paid" {{old('paid') ? 'checked' : ''}}>
                                            <label class="form-check-label" for="paid">
                                                Già pagato
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3">Inserisci</button>
                            </form>
                            <p class="d-block w-100 h4 pt-5 font-weight-bold">Tutti i lavori:</p>
                            <div class="w-100" style="overflow-x:scroll">
                                <script>
                                    var ELEMENT;
                                    function toggleShowDescription(element) {
                                        ELEMENT = element
                                        console.log(element)
                                        if(element.dataset.expanded === "true") {
                                            element.innerText = element.dataset.text.substr(0, 20) + '...'
                                            element.dataset.expanded = "false";
                                        }
                                        else {
                                            element.innerText = element.dataset.text
                                            element.dataset.expanded = "true";
                                        }
                                    }
                                </script>
                                <table class="table table-hover table-bordered thead-dark table-striped" style="white-space: nowrap;">
                                    <thead>
                                    <tr>
                                        <th scope="col">Data</th>
                                        <th scope="col">Pagato</th>
                                        <th scope="col">Tot. ore</th>
                                        <th scope="col">Macchine</th>
                                        <th scope="col">N. lavoratori</th>
                                        <th scope="col">Smaltimento</th>
                                        <th scope="col">Descrizione</th>
                                        <th scope="col">Azioni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($works ?? [] as $work)
                                        <tr>
                                            <td>
                                                {{$work->day->format('d/m/Y')}}<br>
                                                {{$work->begin_at->format('H:i')}} - {{$work->finish_at->format('H:i')}}
                                            </td>
                                            <td>{{$work->paid ? 'Si' : 'No'}}</td>
                                            <td>
                                                {{$work->begin_at->diff($work->finish_at)->format('%H:%I')}}
                                            </td>
                                            <td>{{$work->machines ? 'Si' : 'No'}}</td>
                                            <td>{{$work->number_of_workers}}</td>
                                            <td>€{{$work->disposal ?? 0}}</td>
                                            <td>
                                                <p class="description-text text-break" style="max-width: 150px; white-space: normal;" onclick="toggleShowDescription(this)" data-text="{{$work->description}}" data-expanded="false">
                                                    {{\Illuminate\Support\Str::limit($work->description, 20)}}
                                                </p>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center p-0">
                                                    <div class="p-1">
                                                        <button class="btn btn-primary" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Modifica lavoro">
                                                            <a href="{{route('work.edit', ['work' => $work->id])}}" style="color:white">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                                </svg>
                                                            </a>
                                                        </button>
                                                    </div>
                                                    <div class="p-1">
                                                        @if($work->paid)
                                                            <button class="btn btn-warning" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Segna come non pagato">
                                                                <a href="{{route('work.toggle', ['work'=>$work->id])}}" style="color:black">
                                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                                                    </svg>
                                                                </a>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-success" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Segna come pagato">
                                                                <a href="{{route('work.toggle', ['work'=>$work->id])}}" style="color: white">
                                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                                    </svg>
                                                                </a>
                                                            </button>
                                                        @endif

                                                    </div>
                                                    <div class="p-1">
                                                        <button class="btn btn-danger" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Elimina">
                                                            <a href="{{route('work.delete', ['work'=>$work->id])}}" style="color:white" onclick="return confirm('Sicuro di voler eliminare questo lavoro?');">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                                </svg>
                                                            </a>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center font-weight-bold">Nessun lavoro inserito</td>
                                        </tr>
                                    @endforelse
                                        <tr>
                                            <td colspan="8">Totale ore: <br>{{(int)$client->total_hours_to_pay}}:{{(int)((($client->total_hours_to_pay - (int)$client->total_hours_to_pay))*60)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
