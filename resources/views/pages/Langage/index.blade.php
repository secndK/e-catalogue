@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Langages de Développement</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createLangageModal">
            Ajouter un Langage
        </button>

        <!-- Modal de création -->
        <div class="modal fade" id="createLangageModal" tabindex="-1" aria-labelledby="createLangageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createLangageModalLabel">Ajouter un nouveau langage</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createLangageForm" action="{{ route('langages.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="langage" class="form-label">Nom du langage</label>
                                <input type="text" class="form-control" id="langage" name="langage" required>
                                <div class="invalid-feedback" id="langage_error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="environnement_id" class="form-label">Environnement</label>
                                <select class="form-select" id="environnement_id" name="environnement_id">
                                    <option value="">Sélectionnez un environnement</option>
                                    @foreach ($environnements as $env)
                                        <option value="{{ $env->id }}">{{ $env->nom_env }} - </option>
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
        <div class="modal fade" id="editLangageModal" tabindex="-1" aria-labelledby="editLangageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLangageModalLabel">Modifier le langage</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editLangageForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_langage_id" name="id">
                            <div class="mb-3">
                                <label for="edit_langage" class="form-label">Nom du langage</label>
                                <input type="text" class="form-control" id="edit_langage" name="langage" required>
                                <div class="invalid-feedback" id="edit_langage_error"></div>
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
                    <th>Langage</th>
                    {{-- <th>Environnement</th>
                    <th>Addresse serveur</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($langages as $langage)
                    <tr>
                        <td>{{ $langage->id }}</td>

                        <td>{{ $langage->langage }}</td>
                        {{-- <td>{{ $langage->nom_env ?? 'Non attribué' }}</td>
                        <td>{{ $langage->adr_serv_app ?? 'Non attribué' }}</td> --}}
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-langage" data-id="{{ $langage->id }}"
                                data-langage="{{ $langage->langage }}" data-env="{{ $langage->environnement_id }}">
                                <i class="bi bi-pencil"></i> Editer
                            </button>

                            <button type="button" class="btn btn-danger btn-sm delete-langage"
                                data-id="{{ $langage->id }}">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $langages->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function showAlert(icon, title, text) {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    confirmButtonColor: '#3085d6',
                });
            }

            // Création
            $('#createLangageForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.code === 200) {
                            $('#createLangageModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => location.reload());
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
                            showAlert('error', 'Erreur', 'Erreur lors de la création');
                        }
                    }
                });
            });

            // Édition
            $('.edit-langage').click(function() {
                const id = $(this).data('id');
                const langage = $(this).data('langage');
                const env = $(this).data('env');

                $('#edit_langage_id').val(id);
                $('#edit_langage').val(langage);
                $('#edit_environnement_id').val(env);
                $('#editLangageForm').attr('action', `/langages/${id}`);
                $('#editLangageModal').modal('show');
            });

            $('#editLangageForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.code === 200) {
                            $('#editLangageModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => location.reload());
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
                            showAlert('error', 'Erreur', 'Erreur lors de la mise à jour');
                        }
                    }
                });
            });

            // Suppression
            $('.delete-langage').click(function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "Cette action est irréversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/langages/${id}`,
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
                                    }).then(() => location.reload());
                                } else {
                                    showAlert('error', 'Erreur', response.message);
                                }
                            },
                            error: function() {
                                showAlert('error', 'Erreur',
                                    'Erreur lors de la suppression');
                            }
                        });
                    }
                });
            });

            // Reset modals
            $('#createLangageModal, #editLangageModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').text('');
            });
        });
    </script>
@endsection
