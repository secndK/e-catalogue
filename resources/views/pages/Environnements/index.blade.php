@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Environnements</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Bouton pour ouvrir le modal de création -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createEnvironnementModal">
            Ajouter un Environnement
        </button>
        <table class="table table-bordered table-striped table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Environnement</th>
                    <th>Adresse server</th>
                    <th>Adresse bd</th>
                    <th>Système exp bd</th>
                    {{-- <th>Langage dev</th>
                    <th>os adresse serveur </th>
                    <th>Services critique </th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $rsl)
                    <tr>
                        <td>{{ $rsl->id }}</td>
                        <td>{{ $rsl->nom_env }}</td>
                        <td>{{ $rsl->adr_serv_app }}</td>
                        <td>{{ $rsl->adr_serv_bd }}</td>
                        <td>{{ $rsl->sys_exp_bd }}</td>
                        {{-- <td>{{ $rsl->langage }}</td>
                        <td>{{ $rsl->nom_os }}</td>
                        <td>{{ $rsl->nom_service }}</td> --}}

                        {{-- data-langage="{{ $rsl->langage }}" --}}
                        {{-- data-os-serveur="{{ $rsl->nom_os }}" data-service="{{ $rsl->nom_service }}" --}}
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-environnement"
                                data-id="{{ $rsl->id }}" data-environnement="{{ $rsl->nom_env }}"
                                data-adr-serv-app="{{ $rsl->adr_serv_app }}" data-adr-serv-bd="{{ $rsl->adr_serv_bd }}"
                                data-sys-exp-bd="{{ $rsl->sys_exp_bd }}">
                                <i class="bi bi-pencil"></i> Editer
                            </button>

                            <button type="button" class="btn btn-danger btn-sm delete-langage"
                                data-id="{{ $rsl->id }}">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-left">
            {{ $results->links() }}
        </div>


        <!-- Modal de création -->
        <div class="modal fade" id="createEnvironnementModal" tabindex="-1" aria-labelledby="createEnvironnementLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEnvironnementLabel">Ajouter un nouvel Environnement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createEnvironnementForm" action="{{ route('environnements.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom_env" class="form-label">Nom de l'environnement</label>
                                <input type="text" class="form-control" id="nom_env" name="nom_env" required>
                                <div class="invalid-feedback" id="langage_error"></div>
                            </div>


                            <div class="mb-3">
                                <label for="adr_serv_app" class="form-label">Adresse serveur*</label>
                                <input type="text" class="form-control" id="adr_serv_app" name="adr_serv_app" required>
                                <div class="invalid-feedback" id="langage_error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="sys_exp_bd" class="form-label">Adresse serveur de bd*</label>
                                <input type="text" class="form-control" id="sys_exp_bd" name="sys_exp_bd" required>
                                <div class="invalid-feedback" id="langage_error"></div>
                            </div>


                            <div class="mb-3">
                                <label for="adr_serv_bd" class="form-label">Système exploitation de bd*</label>
                                <input type="text" class="form-control" id="adr_serv_bd" name="adr_serv_bd" required>
                                <div class="invalid-feedback" id="langage_error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="langages_developpement_id" class="form-label">Langage dev*</label>
                                <select class="form-select" id="langages_developpement_id" name="langages_developpement_id">
                                    <option value="">choisir</option>
                                    @foreach ($langages as $lng)
                                        <option value="{{ $lng->id }}">{{ $lng->langage }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="os_serveur_applicatif_id" class="form-label">Système d'exploitation SA*</label>
                                <select class="form-select" id="os_serveur_applicatif_id" name="os_serveur_applicatif_id">
                                    <option value="">choisir</option>
                                    @foreach ($os as $os)
                                        <option value="{{ $os->id }}">{{ $os->nom_os }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="services_monitoring_id" class="form-label">Service critique à monitorer*</label>
                                <select class="form-select" id="services_monitoring_id" name="services_monitoring_id">
                                    <option value="">choisir</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->nom_service }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
