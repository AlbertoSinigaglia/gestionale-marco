@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <p class="d-block w-100 h4 pt-0 font-weight-bold">Modifica cliente</p>
                            <form class="w-100 pb-3 border-bottom" action="{{route('client.update', ['client' => $client->id])}}" method="POST">
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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Inserisci nome del cliente" value="{{old('name') ?? $client->name}}" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="piva">Partita IVA (opzionale):</label>
                                        <input type="text" class="form-control" name="piva" id="piva" placeholder="Inserisci La partita IVA" value="{{old('piva') ?? $client->piva}}" >
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="worker_cost_hourly">Costo orario operaio:</label>
                                        <input required type="number" min="0" step="0.01" class="form-control" name="worker_cost_hourly" value="{{old('worker_cost_hourly')  ?? $client->worker_cost_hourly ?? '8.00'}}" id="worker_cost_hourly" placeholder="Inserisci il costo orario dell'operaio">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="machine_cost_hourly">Costo orario macchine:</label>
                                        <input required type="number" min="0" step="0.01" class="form-control" name="machine_cost_hourly" value="{{old('machine_cost_hourly')  ?? $client->machine_cost_hourly ?? '5.00'}}" id="machine_cost_hourly" placeholder="Inserisci il costo orario per l'uso di macchine">
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="phone">Telefono (opzionale):</label>
                                        <input type="text" class="form-control" name="phone" value="{{old('phone') ?? $client->phone}}" id="phone" placeholder="Inserisci il numero di telefono">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="email">Email (opzionale):</label>
                                        <input type="email" class="form-control" name="email" value="{{old('email') ?? $client->email}}" id="email" placeholder="Inserisci l'email del cliente">
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="address">Indirizzo (opzionale):</label>
                                        <input type="text" class="form-control" name="address" value="{{old('address') ?? $client->address}}" id="address" placeholder="Inserisci l'indirizzo del cliente">
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
