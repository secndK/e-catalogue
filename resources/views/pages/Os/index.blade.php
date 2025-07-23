@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Systèmes d'Exploitation SA</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Bouton pour ouvrir le modal de création -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createOsModal">
            Ajouter un OS
        </button>
        <!-- Modal de création -->
        <div class="modal fade" id="createOsModal" tabindex="-1" aria-labelledby="createOsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createOsModalLabel">Ajouter un nouveau système d'exploitation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createOsForm" action="{{ route('os.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom_os" class="form-label">Nom du système d'exploitation</label>
                                <input type="text" class="form-control" id="nom_os" name="nom_os" required>
                                <div class="invalid-feedback" id="nom_os_error"></div>
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
        <div class="modal fade" id="editOsModal" tabindex="-1" aria-labelledby="editOsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOsModalLabel">Modifier le système d'exploitation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editOsForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_os_id" name="id">
                            <div class="mb-3">
                                <label for="edit_nom_os" class="form-label">Nom du système d'exploitation</label>
                                <input type="text" class="form-control" id="edit_nom_os" name="nom_os" required>
                                <div class="invalid-feedback" id="edit_nom_os_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_environnement_id" class="form-label">Environnement</label>
                                <select class="form-select" id="edit_environnement_id" name="environnement_id">
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

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom du système</th>
                    <th>Environnement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($osList as $os)
                    <tr>
                        <td>{{ $os->id }}</td>
                        <td>{{ $os->nom_os }}</td>
                        <td>{{ $os->nom_env ?? 'Non attribué' }}</td>
                        <td>
                            <!-- Bouton pour ouvrir le modal d'édition -->
                            <button type="button" class="btn btn-primary btn-sm edit-os" data-id="{{ $os->id }}"
                                data-nom="{{ $os->nom_os }}" data-env="{{ $os->environnement_id }}">
                                <i class="bi bi-pencil"></i> Editer
                            </button>

                            <!-- Bouton de suppression -->
                            <button type="button" class="btn btn-danger btn-sm delete-os" data-id="{{ $os->id }}">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-start">
            {{ $osList->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
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

            // Création d'environnement
            $('#createEnvForm').submit(function(e) {
                e.preventDefault();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status ===
                            'success') { // Changé de response.code à response.status
                            $('#createEnvModal').modal('hide');
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
                            const errors = xhr.responseJSON.errors || {};
                            for (const field in errors) {
                                $(`#${field}`).addClass('is-invalid');
                                $(`#${field}_error`).text(errors[field][0]);
                            }
                            showAlert('error', 'Erreur de validation', xhr.responseJSON
                                .message);
                        } else {
                            showAlert('error', 'Erreur',
                                'Une erreur est survenue lors de la création de l\'environnement'
                            );
                        }
                    }
                });
            });

            // Édition d'OS
            $('.edit-os').click(function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');
                const env = $(this).data('env');

                $('#edit_os_id').val(id);
                $('#edit_nom_os').val(nom);
                $('#edit_environnement_id').val(env);

                $('#editOsForm').attr('action', `/os/${id}`);
                $('#editOsModal').modal('show');
            });

            // Soumission du formulaire d'édition
            $('#editOsForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.code === 200) {
                            $('#editOsModal').modal('hide');
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
                                'Une erreur est survenue lors de la mise à jour du système d\'exploitation'
                            );
                        }
                    }
                });
            });

            // Suppression d'OS
            $('.delete-os').click(function() {
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
                            url: `/os/${id}`,
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
                                    'Une erreur est survenue lors de la suppression du système d\'exploitation'
                                );
                            }
                        });
                    }
                });
            });

            // Réinitialiser le formulaire et les erreurs quand le modal est fermé
            $('#createOsModal').on('hidden.bs.modal', function() {
                $('#createOsForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });

            $('#editOsModal').on('hidden.bs.modal', function() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endsection
