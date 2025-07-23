@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Services</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bouton pour ouvrir le modal de création -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createServiceModal">
            Ajouter un Service
        </button>

        <!-- Modal de création -->
        <div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createServiceModalLabel">Ajouter un nouveau service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createServiceForm" action="{{ route('services.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom_service" class="form-label">Nom du service</label>
                                <input type="text" class="form-control" id="nom_service" name="nom_service" required>
                                <div class="invalid-feedback" id="nom_service_error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="environnement_id" class="form-label">Environnement</label>
                                <select class="form-select" id="environnement_id" name="environnement_id">
                                    <option value="">Sélectionnez un environnement</option>
                                    @foreach ($environnements as $env)
                                        <option value="{{ $env->id }}">{{ $env->nom_env }}</option>
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

        <!-- Modal d'édition -->
        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editServiceModalLabel">Modifier le service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editServiceForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_service_id" name="id">
                            <div class="mb-3">
                                <label for="edit_nom_service" class="form-label">Nom du service</label>
                                <input type="text" class="form-control" id="edit_nom_service" name="nom_service"
                                    required>
                                <div class="invalid-feedback" id="edit_nom_service_error"></div>
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

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom du Service</th>
                    <th>Environnement</th>
                    <th>Address server</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->nom_service }}</td>
                        <td>{{ $service->nom_env ?? 'Non attribué' }}</td>

                        <td>
                            <!-- Bouton pour ouvrir le modal d'édition -->
                            <button type="button" class="btn btn-primary btn-sm edit-service" data-id="{{ $service->id }}"
                                data-nom="{{ $service->nom_service }}" data-env="{{ $service->environnement_id }}">
                                <i class="bi bi-pencil"></i> Editer
                            </button>

                            <!-- Bouton de suppression -->
                            <button type="button" class="btn btn-danger btn-sm delete-service"
                                data-id="{{ $service->id }}">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>

                        </td>
                        <!-- Bouton pour ouvrir le modal d'édition -->
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-start">
            {{ $services->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Fonction pour afficher les notifications SweetAlert
            function showAlert(icon, title, text) {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    confirmButtonColor: '#3085d6',
                });
            }

            // Création de service
            $('#createServiceForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.code === 200) {
                            $('#createServiceModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            showAlert('error', 'Erreur', response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 400) {
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                $(`#${field}`).addClass('is-invalid');
                                $(`#${field}_error`).text(errors[field][0]);
                            }
                        } else {
                            showAlert('error', 'Erreur',
                                'Une erreur est survenue lors de la création du service');
                        }
                    }
                });
            });

            // Édition de service
            $('.edit-service').click(function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');
                const env = $(this).data('env');

                $('#edit_service_id').val(id);
                $('#edit_nom_service').val(nom);
                $('#edit_environnement_id').val(env);

                $('#editServiceForm').attr('action', `/services/${id}`);
                $('#editServiceModal').modal('show');
            });

            // Soumission du formulaire d'édition
            $('#editServiceForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.code === 200) {
                            $('#editServiceModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            showAlert('error', 'Erreur', response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 400) {
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                $(`#edit_${field}`).addClass('is-invalid');
                                $(`#edit_${field}_error`).text(errors[field][0]);
                            }
                        } else {
                            showAlert('error', 'Erreur',
                                'Une erreur est survenue lors de la mise à jour du service');
                        }
                    }
                });
            });

            // Suppression de service
            $('.delete-service').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "Vous ne pourrez pas revenir en arrière!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/services/${id}`,
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.code === 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Supprimé!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    showAlert('error', 'Erreur', response.message);
                                }
                            },
                            error: function(xhr) {
                                showAlert('error', 'Erreur',
                                    'Une erreur est survenue lors de la suppression du service'
                                );
                            }
                        });
                    }
                });
            });

            // Réinitialiser le formulaire et les erreurs quand le modal est fermé
            $('#createServiceModal').on('hidden.bs.modal', function() {
                $('#createServiceForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });

            $('#editServiceModal').on('hidden.bs.modal', function() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endsection
