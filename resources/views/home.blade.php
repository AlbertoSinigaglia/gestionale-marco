@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <h3 class="pb-3 border-bottom w-100 font-weight-bold">Lista clienti</h3>




                        <p class="d-block w-100 h4 pt-5 font-weight-bold border-bottom pb-2">I tuoi clienti:</p>
                        <div class="row m-0 p-0 w-100">
                            @forelse($clients as $client)
                            <div class="col-12 m-0 p-0">
                                <div class="row m-0 p-0 border-bottom">
                                    <div class="col-11 pt-2 mb-2 pl-0 ml-0 pl-md-2" style="min-height: 90px">
                                        <h4 class="font-weight-bold"><a href="{{route('client', ['client' => $client->id])}}">{{$client->name}}</a> (Tot: €{{$client->amount}})</h4>
                                        @if(filled($client->address))<h6>Indirizzo: {{$client->address}}</h6>@endif
                                        @if(filled($client->piva))<h6>P. IVA: {{$client->piva}}</h6>@endif
                                        @if(filled($client->phone))<h6>N. di tel: <a href="callto:{{$client->phone}}">{{$client->phone}}</a></h6>@endif
                                        @if(filled($client->email))<h6>Email: <a href="mailto:{{$client->email}}">{{$client->email}}</a></h6>@endif
                                    </div>
                                    <div class="col-1 d-flex justify-content-center p-0 align-items-center flex-column pt-2 pb-2">
                                        <div class="p-1">
                                            <button class="btn btn-success" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Modifica lavoro">
                                                <a href="{{route('client', ['client' => $client->id])}}" style="color:white">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                    </svg>
                                                </a>
                                            </button>
                                        </div>
                                        <div class="p-1">
                                            <button class="btn btn-primary" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Modifica lavoro">
                                                <a href="{{route('client.edit', ['client' => $client->id])}}" style="color:white">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                    </svg>
                                                </a>
                                            </button>
                                        </div>

                                        <div class="p-1">
                                            <button class="btn btn-danger" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Elimina">
                                                <a href="{{route('client.delete', ['client'=>$client->id])}}" style="color:white" onclick="return confirm('Sicuro di voler eliminare questo cliente?');">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                    </svg>
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="col-12 border-top pt-2 mb-2">
                                    <h4 class="text-center">Nessun cliente inserito</h4>
                                </div>
                            @endforelse
                        </div>





                        <p class="d-block w-100 h4 pt-5 font-weight-bold">Inserisci nuovo cliente</p>
                        <form class="w-100 pb-3 border-bottom" action="{{route('client.create')}}" method="POST">
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
                            <div class="row pt-2">
                                <div class="col-md-6 col-sm-12">
                                    <label for="name">Nome:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Inserisci nome del cliente" value="{{old('name')}}" required>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="piva">Partita IVA (opzionale):</label>
                                    <input type="text" class="form-control" name="piva" id="piva" placeholder="Inserisci La partita IVA" value="{{old('piva')}}" >
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-6 col-sm-12">
                                    <label for="worker_cost_hourly">Costo orario operaio:</label>
                                    <input required type="number" min="0" step="0.01" class="form-control" name="worker_cost_hourly" value="{{old('worker_cost_hourly') ?? '8.00'}}" id="worker_cost_hourly" placeholder="Inserisci il costo orario dell'operaio">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="machine_cost_hourly">Costo orario macchine:</label>
                                    <input required type="number" min="0" step="0.01" class="form-control" name="machine_cost_hourly" value="{{old('machine_cost_hourly') ?? '5.00'}}" id="machine_cost_hourly" placeholder="Inserisci il costo orario per l'uso di macchine">
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-6 col-sm-12">
                                    <label for="phone">Telefono (opzionale):</label>
                                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" id="phone" placeholder="Inserisci il numero di telefono">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="email">Email (opzionale):</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" placeholder="Inserisci l'email del cliente">
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-12 col-sm-12">
                                    <label for="address">Indirizzo (opzionale):</label>
                                    <input type="text" class="form-control" name="address" value="{{old('address')}}" id="address" placeholder="Inserisci l'indirizzo del cliente">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Inserisci</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
