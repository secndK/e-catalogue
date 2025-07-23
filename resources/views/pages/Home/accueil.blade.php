@extends('layouts.app')

@section('title', 'E-CATALOGUE')

@section('content')
    <div class="px-4 container-fluid">

        <div class="row">
            <div class="col-12">
                <!-- Barre de recherche -->
                <form action="{{ route('catalogue') }}" method="POST" class="mb-4" id="searchForm">
                    @csrf
                    <div class="search-container">
                        <div class="search-box {{ !empty($search_query) ? 'active' : '' }}" id="searchBox">
                            <div class="search-icon" id="searchIcon">
                                <i class="bi bi-search"></i> <!-- Utilisation d'une icône Bootstrap Icons -->
                            </div>
                            <input type="text" class="search-input" id="searchInput" name="rechercher"
                                placeholder="Rechercher une application..." value="{{ $search_query ?? '' }}">
                            <div class="close-btn" id="closeBtn">
                                <i class="bi bi-x"></i> <!-- Utilisation d'une icône Bootstrap Icons -->
                            </div>
                        </div>

                    </div>
                </form>
                <!-- Bouton pour afficher toutes les applications -->

                <!-- Résultats de recherche -->
                <!-- Résultats de recherche -->
                <div class="search-results" id="searchResults">
                    @if (!empty($search_query))
                        @if ($catalogue->count() > 0)
                            <div class="result-count mb-3">
                                <span class="text-primary fw-bold">
                                    <i class="bi bi-check-circle-fill"></i> Résultats pour "{{ $search_query }}"
                                </span>
                            </div>

                            <div class="row g-4" id="cardsContainer">
                                @foreach ($catalogue as $app)
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card shadow-sm h-100 border-0 overflow-hidden">
                                            <div class="card-body position-relative">
                                                <!-- Menu d'actions -->
                                                <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                                    <button class="btn btn-sm btn-outline-secondary rounded-circle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button class="dropdown-item view-app" data-bs-toggle="modal"
                                                                data-bs-target="#appDetailsModal"
                                                                data-app-id="{{ $app->id }}">
                                                                <i class="bi bi-eye-fill me-2"></i>Voir
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item edit-app"
                                                                data-app-id="{{ $app->id }}"
                                                                data-app-name="{{ $app->app_name }}" data-bs-toggle="modal"
                                                                data-bs-target="#editAppModal">
                                                                <i class="bi bi-pencil-fill me-2"></i>Modifier
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger delete-app"
                                                                data-app-id="{{ $app->id }}"
                                                                data-app-name="{{ $app->app_name }}">
                                                                <i class="bi bi-trash-fill me-2"></i>Supprimer
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Nom de l'application -->
                                                <h5 class="card-title fw-bold text-dark mb-3">
                                                    <i class="bi bi-box-seam text-primary"></i> {{ $app->app_name }}
                                                </h5>

                                                <!-- Adresse serveur -->
                                                @if (!empty($app->adr_serv))
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-hdd-network me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->adr_serv }}</small>
                                                    </div>
                                                @endif

                                                <!-- ENVIRONNEMENTS -->
                                                @if (!empty($app->env_prod))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-success me-2">PROD</span>
                                                        <small class="text-muted">{{ $app->adr_serv_prod }}</small>
                                                    </div>
                                                @endif

                                                @if (!empty($app->env_test))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-warning text-dark me-2">TEST</span>
                                                        <small class="text-muted">{{ $app->adr_serv }}</small>
                                                    </div>
                                                @endif

                                                @if (!empty($app->env_dev))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-info text-dark me-2">DEV</span>
                                                        <small class="text-muted">{{ $app->adr_serv_dev }}</small>
                                                    </div>
                                                @endif

                                                <!-- Langage / OS / Criticité -->
                                                @if (!empty($app->lang_dev))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-code-slash me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->lang_dev }}</small>
                                                    </div>
                                                @endif

                                                @if (!empty($app->sys_exp))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-terminal-dash me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->sys_exp }}</small>
                                                    </div>
                                                @endif

                                                <!-- Base de données -->
                                                @if (!empty($app->adr_serv_bd))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-database me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->adr_serv_bd }}</small>
                                                    </div>
                                                @endif

                                                @if (!empty($app->sys_exp_bd))
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-cpu me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->sys_exp_bd }}</small>
                                                    </div>
                                                @endif

                                                <!-- Criticité -->
                                                @if (!empty($app->critical))
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
                                                        <small
                                                            class="text-danger fw-bold">{{ strtoupper($app->critical) }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-12 mt-0">
                                <div class="text-center py-5">
                                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                                    <h4 class="text-muted mt-3">Aucun résultat trouvé</h4>
                                    <p class="text-muted">Essayez avec d'autres mots-clés</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-12 mt-0">
                            <div class="text-center py-5">
                                <p class="text-muted">Utilisez la barre de recherche pour trouver les applications du
                                    catalogue</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Modal pour les détails -->
    <div class="modal fade" id="appDetailsModal" tabindex="-1" aria-labelledby="appDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="appDetailsModalLabel">Détails de l'application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody id="appDetailsContent">
                            <!-- Contenu dynamique injecté ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de création -->
    <div class="modal fade" id="createAppModal" tabindex="-1" aria-labelledby="createAppModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="createAppModalLabel">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                        Nouvelle Application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <form action="{{ route('catalogue.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="createAppErrors" class="alert alert-danger d-none"></div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="app_name" class="form-label fw-bold">
                                    <i class="bi bi-box-seam me-1"></i> Nom de l'application*
                                </label>
                                <input type="text" class="form-control" id="app_name" name="app_name" required>
                            </div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-primary fw-bold mb-3">
                                <i class="bi bi-code-square me-1"></i> Environnement Développement
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_dev" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="env_dev" name="env_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_dev" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="adr_serv_dev" name="adr_serv_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_dev" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="sys_exp_dev" name="sys_exp_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_dev" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_dev"
                                        name="adr_serv_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_dev" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_dev"
                                        name="sys_exp_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_dev" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="lang_deve_dev" name="lang_deve_dev">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_dev" class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="critical_dev" name="critical_dev">
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-warning fw-bold mb-3">
                                <i class="bi bi-bug me-1"></i> Environnement Test
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_test" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="env_test" name="env_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_test" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="adr_serv_test" name="adr_serv_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_test" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="sys_exp_test" name="sys_exp_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_test" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_test"
                                        name="adr_serv_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_test" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_test"
                                        name="sys_exp_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_test" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="lang_deve_test"
                                        name="lang_deve_test">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_test" class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="critical_test" name="critical_test">
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-success fw-bold mb-3">
                                <i class="bi bi-check-circle me-1"></i> Environnement Production
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_prod" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="env_prod" name="env_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_prod" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="adr_serv_prod" name="adr_serv_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_prod" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="sys_exp_prod" name="sys_exp_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_prod" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_prod"
                                        name="adr_serv_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_prod" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_prod"
                                        name="sys_exp_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_prod" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="lang_deve_prod"
                                        name="lang_deve_prod">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_prod" class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="critical_prod" name="critical_prod">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal de modification -->
    <!-- Modal de modification -->
    <div class="modal fade" id="editAppModal" tabindex="-1" aria-labelledby="editAppModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editAppModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Modifier l'application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form id="editAppForm" method="POST">
                    @csrf
                    <input type="hidden" id="edit_app_id" name="id">

                    <div class="modal-body">
                        <div id="editAppErrors" class="alert alert-danger d-none"></div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="edit_app_name" class="form-label fw-bold">
                                    <i class="bi bi-box-seam me-1"></i> Nom de l'application*
                                </label>
                                <input type="text" class="form-control" id="edit_app_name" name="app_name" required>
                            </div>
                        </div>

                        <!-- Environnement DEV -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-primary fw-bold mb-3">
                                <i class="bi bi-code-square me-1"></i> Environnement Développement
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4"><label for="edit_env_dev" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_dev" name="env_dev">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_dev" class="form-label">Adresse
                                        Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_dev"
                                        name="adr_serv_dev">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_dev" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_dev" name="sys_exp_dev">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_bd_dev" class="form-label">Adresse
                                        BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_dev"
                                        name="adr_serv_bd_dev">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_bd_dev" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_dev"
                                        name="sys_exp_bd_dev">
                                </div>
                                <div class="col-md-4"><label for="edit_lang_deve_dev" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_dev"
                                        name="lang_deve_dev">
                                </div>
                                <div class="col-md-12"><label for="edit_critical_dev"
                                        class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="edit_critical_dev"
                                        name="critical_dev">
                                </div>
                            </div>
                        </div>

                        <!-- Environnement TEST -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-warning fw-bold mb-3">
                                <i class="bi bi-bug me-1"></i> Environnement Test
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4"><label for="edit_env_test" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_test" name="env_test">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_test" class="form-label">Adresse
                                        Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_test"
                                        name="adr_serv_test">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_test" class="form-label">OS
                                        Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_test"
                                        name="sys_exp_test">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_bd_test" class="form-label">Adresse
                                        BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_test"
                                        name="adr_serv_bd_test">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_bd_test" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_test"
                                        name="sys_exp_bd_test">
                                </div>
                                <div class="col-md-4"><label for="edit_lang_deve_test" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_test"
                                        name="lang_deve_test">
                                </div>
                                <div class="col-md-12"><label for="edit_critical_test"
                                        class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="edit_critical_test"
                                        name="critical_test">
                                </div>
                            </div>
                        </div>

                        <!-- Environnement PROD -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-success fw-bold mb-3">
                                <i class="bi bi-check-circle me-1"></i> Environnement Production
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4"><label for="edit_env_prod" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_prod" name="env_prod">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_prod" class="form-label">Adresse
                                        Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_prod"
                                        name="adr_serv_prod">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_prod" class="form-label">OS
                                        Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_prod"
                                        name="sys_exp_prod">
                                </div>
                                <div class="col-md-4"><label for="edit_adr_serv_bd_prod" class="form-label">Adresse
                                        BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_prod"
                                        name="adr_serv_bd_prod">
                                </div>
                                <div class="col-md-4"><label for="edit_sys_exp_bd_prod" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_prod"
                                        name="sys_exp_bd_prod">
                                </div>
                                <div class="col-md-4"><label for="edit_lang_deve_prod" class="form-label">Langage</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_prod"
                                        name="lang_deve_prod">
                                </div>
                                <div class="col-md-12"><label for="edit_critical_prod"
                                        class="form-label">Criticité</label>
                                    <input type="text" class="form-control" id="edit_critical_prod"
                                        name="critical_prod">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save2 me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const searchIcon = document.getElementById('searchIcon');
            const searchInput = document.getElementById('searchInput');
            const closeBtn = document.getElementById('closeBtn');
            const searchForm = document.getElementById('searchForm');
            const searchResults = document.getElementById('searchResults');
            const createForm = document.querySelector('#createAppModal form');
            const showAllAppsBtn = document.getElementById('showAllAppsBtn'); // Nouveau sélecteur pour le bouton

            // Handle flash messages for non-AJAX submissions
            @if (session('success'))
                Swal.fire({
                    title: 'Parfait !',
                    html: `
                        <div class="text-center">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            <br><br>
                            <strong>{{ session('success') }}</strong>
                            <br>
                            <small class="text-muted">La page va se recharger automatiquement</small>
                        </div>
                    `,
                    icon: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745',
                    background: '#fff',
                    customClass: {
                        popup: 'animated fadeInUp faster'
                    }
                }).then((result) => {
                    location.reload();
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Oops... Erreur !',
                    html: `
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                            <br><br>
                            <strong>{{ session('error') }}</strong>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonText: 'Réessayer',
                    confirmButtonColor: '#dc3545',
                    background: '#fff',
                    customClass: {
                        popup: 'animated shake faster'
                    }
                });
            @endif

            // Ouvrir la barre de recherche
            searchIcon.addEventListener('click', () => {
                searchBox.classList.add('active');
                setTimeout(() => searchInput.focus(), 200);
            });

            // Fermer la barre de recherche
            closeBtn.addEventListener('click', () => {
                searchBox.classList.remove('active');
                searchInput.value = '';
                updateResults([], '');
                refreshRecentSearches();
            });

            // Gestion des clics sur les recherches récentes
            function attachRecentSearchEvents() {
                document.querySelectorAll('.recent-search-link').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        const searchTerm = this.getAttribute('data-search');
                        searchInput.value = searchTerm;
                        searchBox.classList.add('active');
                        performAjaxSearch(searchTerm);
                    });
                });
            }

            // Soumission automatique après saisie
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();

                if (query.length > 2) {
                    searchTimeout = setTimeout(() => {
                        performAjaxSearch(query);
                    }, 900);
                } else if (query.length === 0) {
                    updateResults([], '');
                    refreshRecentSearches();
                }
            });

            // Recherche AJAX
            function performAjaxSearch(query) {
                fetch('{{ route('catalogue') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: 'rechercher=' + encodeURIComponent(query)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateResults(data.data, data.query);
                            refreshRecentSearches();
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Mettre à jour les résultats de recherche
            function updateResults(results, query) {
                let html = '';

                if (query && query.length > 0 && results.length > 0) {
                    html += `<div class="result-count mb-3">
            <span class="text-primary fw-bold">
                <i class="bi bi-check-circle-fill"></i> Résultats pour "${query}"
            </span>
        </div>
        <div class="row g-4" id="cardsContainer">`;

                    results.forEach((item, index) => {
                        html += `
                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm h-100 border-0 overflow-hidden">
                        <div class="card-body position-relative">
                            <!-- Menu d'actions -->
                            <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                <button class="btn btn-sm btn-outline-secondary rounded-circle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item view-app"
                                                data-bs-toggle="modal"
                                                data-bs-target="#appDetailsModal"
                                                data-app='${JSON.stringify(item)}'>
                                            <i class="bi bi-eye-fill me-2"></i>Voir
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item edit-app" data-app-id="${item.id}">
                                            <i class="bi bi-pencil-fill me-2"></i>Modifier
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger delete-app" data-app-id="${item.id}" data-app-name="${item.app_name}">
                                            <i class="bi bi-trash-fill me-2"></i>Supprimer
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-title fw-bold text-dark mb-3">
                                <i class="bi bi-box-seam text-primary"></i> ${item.app_name}
                            </h5>

                            ${item.adr_serv ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <i class="bi bi-hdd-network me-2 text-muted"></i>
                                                                                                                                    <small class="text-muted">${item.adr_serv}</small>
                                                                                                                                </div>` : ''}

                            ${item.env_dev ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <span class="badge bg-warning text-dark me-2">DEV</span>
                                                                                                                                    <small class="text-muted">${item.adr_serv_dev}</small>
                                                                                                                                </div>` : ''}

                            ${item.env_test ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <span class="badge bg-info text-dark me-2">TEST</span>
                                                                                                                                    <small class="text-muted">${item.adr_serv_test}</small>
                                                                                                                                </div>` : ''}

                            ${item.env_prod ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <span class="badge bg-success me-2">PROD</span>
                                                                                                                                    <small class="text-muted">${item.adr_serv_prod}</small>
                                                                                                                                </div>` : ''}

                            ${item.sys_exp ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <i class="bi bi-cpu me-2 text-muted"></i>
                                                                                                                                    <small class="text-muted">OS : ${item.sys_exp}</small>
                                                                                                                                </div>` : ''}

                            ${item.lang_dev ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <i class="bi bi-code-slash me-2 text-muted"></i>
                                                                                                                                    <small class="text-muted">Langage : ${item.lang_dev}</small>
                                                                                                                                </div>` : ''}

                            ${item.adr_serv_bd ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <i class="bi bi-server me-2 text-muted"></i>
                                                                                                                                    <small class="text-muted">BD : ${item.adr_serv_bd}</small>
                                                                                                                                </div>` : ''}

                            ${item.sys_exp_bd ? `
                                                                                                                                <div class="d-flex align-items-center mb-2">
                                                                                                                                    <i class="bi bi-hdd me-2 text-muted"></i>
                                                                                                                                    <small class="text-muted">OS BD : ${item.sys_exp_bd}</small>
                                                                                                                                </div>` : ''}

                            ${item.critical ? `
                                                                                                                                <div class="mt-3">
                                                                                                                                    <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> Critique</span>
                                                                                                                                </div>` : ''}
                        </div>
                    </div>
                </div>
            `;
                    });

                    html += '</div>';
                } else {
                    html = `
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">${query ? 'Aucun résultat trouvé' : 'Recherchez une application'}</h4>
                    <p class="text-muted">${query ? 'Essayez avec d\'autres mots-clés' : 'Utilisez la barre de recherche pour trouver des applications'}</p>
                </div>
            </div>`;
                }

                document.getElementById('searchResults').innerHTML = html;
            }



            // Gestion du bouton "Afficher toutes les applications"
            if (showAllAppsBtn) {
                showAllAppsBtn.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Chargement...',
                        text: 'Récupération de toutes les applications',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('catalogue.all') }}', {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                searchInput.value = ''; // Réinitialiser la barre de recherche
                                searchBox.classList.remove('active'); // Fermer la barre de recherche
                                updateResults(data.data, ''); // Afficher toutes les applications
                                refreshRecentSearches(); // Rafraîchir les recherches récentes
                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: data.message ||
                                        'Impossible de récupérer les applications',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Erreur:', error);
                            Swal.fire({
                                title: 'Erreur de connexion',
                                text: 'Impossible de communiquer avec le serveur',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                });
            }



            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Désactiver le bouton de soumission
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<i class="bi bi-hourglass-split me-1"></i> Enregistrement...';

                    // Afficher un loading pendant la requête
                    Swal.fire({
                        title: 'Création en cours...',
                        text: 'Veuillez patienter',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            return response.json().then(data => ({
                                status: response.status,
                                ok: response.ok,
                                data: data
                            }));
                        })
                        .then(({
                            status,
                            ok,
                            data
                        }) => {
                            if (ok && data.success) {
                                // Fermer le modal d'abord
                                const modal = bootstrap.Modal.getInstance(document
                                    .getElementById('createAppModal'));
                                modal.hide();
                                this.reset();

                                // Afficher SweetAlert de succès avec animation
                                Swal.fire({
                                    title: 'Parfait !',
                                    html: `
                                    <div class="text-center">
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                                        <br><br>
                                        <strong>Application créée avec succès !</strong>
                                        <br>
                                        <small class="text-muted">La page va se recharger automatiquement</small>
                                    </div>
                                `,
                                    icon: 'success',
                                    showConfirmButton: true,

                                    background: '#fff',
                                    customClass: {
                                        popup: 'animated fadeInUp faster'
                                    }
                                }).then((result) => {
                                    // Recharger la page
                                    location.reload();
                                });
                            } else {
                                // Erreur côté serveur
                                let errorMessage = 'Une erreur est survenue lors de la création';
                                let errorDetails = '';

                                if (status === 422 && data.errors) {
                                    // Erreurs de validation Laravel
                                    const errors = Object.values(data.errors).flat();
                                    errorMessage = 'Erreurs de validation détectées';
                                    errorDetails = '<ul class="text-left">' + errors.map(
                                        err => `<li>${err}</li>`).join('') + '</ul>';
                                } else if (data.message) {
                                    errorMessage = data.message;
                                }

                                Swal.fire({
                                    title: 'Oops... Erreur !',
                                    html: `
                                    <div class="text-center">
                                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                                        <br><br>
                                        <strong>${errorMessage}</strong>
                                        ${errorDetails ? '<br><br>' + errorDetails : ''}
                                    </div>
                                `,
                                    icon: 'error',
                                    confirmButtonText: 'Réessayer',
                                    confirmButtonColor: '#dc3545',
                                    background: '#fff',
                                    customClass: {
                                        popup: 'animated shake faster'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            Swal.fire({
                                title: 'Erreur de connexion !',
                                html: `
                                <div class="text-center">
                                    <i class="bi bi-wifi-off text-warning" style="font-size: 4rem;"></i>
                                    <br><br>
                                    <strong>Impossible de communiquer avec le serveur</strong>
                                    <br>
                                    <small class="text-muted">Vérifiez votre connexion internet</small>
                                </div>
                            `,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545',
                                background: '#fff'
                            });
                        })
                        .finally(() => {
                            // Réactiver le bouton
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            }

            // Handle app details modal
            document.addEventListener('shown.bs.modal', function(event) {
                if (event.target.id === 'appDetailsModal') {
                    const button = event.relatedTarget;
                    const app = JSON.parse(button.getAttribute('data-app'));

                    const section = (title) => `
            <tr class="table-light">
                <th colspan="2" class="text-primary text-uppercase fw-bold">${title}</th>
            </tr>
        `;

                    const row = (label, value) => `
            <tr>
                <th class="w-50">${label}</th>
                <td>${value || '<span class="text-muted">-</span>'}</td>
            </tr>
        `;

                    const detailsBody = document.getElementById('appDetailsContent');
                    detailsBody.innerHTML = `
            ${row("Nom de l'application", app.app_name)}

            ${section("Environnement Développement")}
            ${row(" Nom environnement", app.env_dev)}
            ${row("Adresse Serveur", app.adr_serv_dev)}
            ${row("OS Serveur", app.sys_exp_dev)}
            ${row("Adresse Serveur BD", app.adr_serv_bd_dev)}
            ${row("OS BD", app.sys_exp_bd_dev)}
            ${row("Langage", app.lang_deve_dev)}
            ${row("Criticité", app.critical_dev)}

            ${section("Environnement Test")}
            ${row("Nom environnement", app.env_test)}
            ${row("Adresse Serveur", app.adr_serv_test)}
            ${row("OS Serveur", app.sys_exp_test)}
            ${row("Adresse Serveur BD", app.adr_serv_bd_test)}
            ${row("OS BD", app.sys_exp_bd_test)}
            ${row("Langage", app.lang_deve_test)}
            ${row("Criticité", app.critical_test)}

            ${section("Environnement Production")}
            ${row("Nom environnement", app.env_prod)}
            ${row("Adresse Serveur", app.adr_serv_prod)}
            ${row("OS Serveur", app.sys_exp_prod)}
            ${row("Adresse Serveur BD", app.adr_serv_bd_prod)}
            ${row("OS BD", app.sys_exp_bd_prod)}
            ${row("Langage", app.lang_deve_prod)}
            ${row("Criticité", app.critical_prod)}
        `;
                }
            });

            // Rafraîchir les recherches récentes dans la sidebar
            function refreshRecentSearches() {
                fetch('{{ route('get.recent.searches') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const sidebarNav = document.querySelector('.sidebar-nav');
                            if (sidebarNav) {
                                // Supprimer anciennes recherches
                                sidebarNav.querySelectorAll(
                                        '.recent-searches-header, .recent-search-item, .clear-searches-btn')
                                    .forEach(el => el.remove());

                                // Ajouter le bouton de suppression dans sidebar-cta
                                const sidebarCta = document.querySelector('.sidebar-cta .sidebar-cta-content');
                                if (sidebarCta) {
                                    const clearBtnContainer = document.createElement('div');
                                    clearBtnContainer.className = 'mt-2 text-center';
                                    clearBtnContainer.innerHTML = `
                            <button class="btn btn-sm btn-outline-danger clear-searches-btn" title="Effacer l'historique">
                                <i class="bi bi-trash me-1"></i> Effacer l'historique
                            </button>
                        `;
                                    sidebarCta.appendChild(clearBtnContainer);

                                    // Bouton de suppression
                                    const clearBtn = clearBtnContainer.querySelector('.clear-searches-btn');
                                    clearBtn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        clearAllRecentSearches();
                                    });
                                }

                                // Point d'insertion pour les recherches
                                const menuItem = sidebarNav.querySelector('.sidebar-item');

                                if (menuItem && data.recent_searches.length > 0) {
                                    // Titre des recherches
                                    const recentHeader = document.createElement('li');
                                    recentHeader.className = 'sidebar-header recent-searches-header';
                                    recentHeader.innerHTML = `
                            <i class="bi bi-clock-history me-2"></i>
                            Recherches Récentes
                        `;
                                    sidebarNav.insertBefore(recentHeader, menuItem.nextSibling);

                                    // Liste des recherches
                                    data.recent_searches.forEach(search => {
                                        const recentItem = document.createElement('li');
                                        recentItem.className = 'sidebar-item recent-search-item';
                                        recentItem.innerHTML = `
                                <a class="sidebar-link recent-search-link" href="#" data-search="${search.search_term}">
                                    <i class="bi bi-search me-2"></i>
                                    <span>${search.search_term}</span>
                                    <small class="text-muted ms-2">(${search.results_count} résultats)</small>
                                </a>
                            `;
                                        sidebarNav.insertBefore(recentItem, recentHeader.nextSibling);
                                    });
                                }

                                attachRecentSearchEvents();
                            }
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Fonction pour vider l'historique avec SweetAlert2
            function clearAllRecentSearches() {
                Swal.fire({
                    title: 'Confirmer la suppression',
                    text: "Voulez-vous vraiment supprimer toutes vos recherches récentes ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('clear.search.history') }}', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    refreshRecentSearches();
                                    Swal.fire({
                                        title: 'Succès !',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Erreur:', error);
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Une erreur est survenue lors de la suppression',
                                    icon: 'error'
                                });
                            });
                    }
                });
            }

            // ===== ÉDITION D'APPLICATION =====
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-app')) {
                    const button = e.target.closest('.edit-app');
                    const appId = button.dataset.appId;

                    console.log('🔍 Édition app ID:', appId);

                    const editModal = new bootstrap.Modal(document.getElementById('editAppModal'));
                    const modalBody = document.querySelector('#editAppModal .modal-body');
                    const originalContent = modalBody.innerHTML;

                    // Spinner de chargement
                    modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-2">Chargement des données...</p>
            </div>
        `;

                    editModal.show();

                    fetch(`/catalogue/${appId}/edit`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            console.log('📡 Statut réponse:', response.status);
                            if (!response.ok) {
                                throw new Error(`Erreur HTTP: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('📦 Données reçues:', data);

                            if (!data.success) {
                                throw new Error(data.message || 'Erreur inconnue');
                            }

                            // Restaurer le contenu du modal
                            modalBody.innerHTML = originalContent;

                            const appData = data.data;

                            const fields = [
                                'app_name',
                                'adr_serv_dev', 'env_dev', 'sys_exp_dev', 'adr_serv_bd_dev',
                                'sys_exp_bd_dev', 'lang_deve_dev', 'critical_dev',
                                'adr_serv_prod', 'env_prod', 'sys_exp_prod', 'adr_serv_bd_prod',
                                'sys_exp_bd_prod', 'lang_deve_prod', 'critical_prod',
                                'adr_serv_test', 'env_test', 'sys_exp_test', 'adr_serv_bd_test',
                                'sys_exp_bd_test', 'lang_deve_test', 'critical_test',
                                'commentaires', 'adr_serv'
                            ];

                            fields.forEach(field => {
                                const element = document.getElementById(`edit_${field}`);
                                if (element) {
                                    element.value = appData[field] || '';
                                }
                            });

                            document.getElementById('edit_app_id').value = appData.id;
                            const form = document.getElementById('editAppForm');
                            form.action = `/catalogue/${appData.id}`;

                            const methodField = form.querySelector('input[name="_method"]');
                            if (methodField) {
                                methodField.value = 'PUT';
                            }
                        })
                        .catch(error => {
                            console.error('❌ Erreur:', error);
                            modalBody.innerHTML = originalContent;
                            editModal.hide();

                            Swal.fire({
                                title: 'Erreur de chargement',
                                text: error.message,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });

            // ===== SOUMISSION DU FORMULAIRE =====
            document.getElementById('editAppForm')?.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                console.log('📝 Soumission formulaire vers:', form.action);
                console.log('📝 Données:', Object.fromEntries(formData));

                submitBtn.disabled = true;
                submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1"></span>
        Enregistrement...
    `;

                Swal.fire({
                    title: 'Mise à jour en cours',
                    text: 'Veuillez patienter...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        console.log('📡 Statut mise à jour:', response.status);

                        if (!response.ok) {
                            if (response.status === 405) {
                                throw new Error('Méthode non autorisée. Vérifiez vos routes Laravel.');
                            } else if (response.status === 404) {
                                throw new Error('Application non trouvée.');
                            } else if (response.status === 422) {
                                return response.json().then(data => {
                                    const errors = data.errors ? Object.values(data.errors)
                                        .flat().join('\n') : data.message;
                                    throw new Error(errors);
                                });
                            } else {
                                throw new Error(`Erreur serveur: ${response.status}`);
                            }
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Succès:', data);

                        if (!data.success) {
                            throw new Error(data.message || 'Échec de la mise à jour');
                        }

                        Swal.fire({
                            title: 'Succès !',
                            text: data.message || 'Application mise à jour avec succès',
                            icon: 'success',
                            confirmButtonColor: '#28a745',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            const editModal = bootstrap.Modal.getInstance(document
                                .getElementById('editAppModal'));
                            editModal.hide();
                            location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('❌ Erreur mise à jour:', error);

                        Swal.fire({
                            title: 'Erreur',
                            text: error.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
            });


            // Gestion de la suppression d'application
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-app')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-app');
                    const appId = button.getAttribute('data-app-id');
                    const appName = button.getAttribute('data-app-name') || 'cette application';

                    Swal.fire({
                        title: 'Confirmer la suppression',
                        html: `Êtes-vous sûr de vouloir supprimer <strong>${appName}</strong> ?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        backdrop: `
                            rgba(0,0,0,0.7)
                            url("${window.location.origin}/images/trash-icon.png")
                            center top
                            no-repeat
                        `,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteApplication(appId);
                        }
                    });
                }
            });

            // Fonction pour supprimer une application via AJAX
            async function deleteApplication(appId) {
                try {
                    // Afficher un indicateur de chargement
                    const swalInstance = Swal.fire({
                        title: 'Suppression en cours',
                        html: 'Veuillez patienter...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await fetch(`/catalogue/${appId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    // Fermer l'indicateur de chargement
                    await swalInstance.close();

                    if (response.ok && data.success) {
                        // Afficher un message de succès
                        Swal.fire({
                            title: 'Supprimé !',
                            text: data.message || 'Application supprimée avec succès',
                            icon: 'success',
                            confirmButtonColor: '#28a745',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            // Recharger la page ou actualiser dynamiquement le contenu
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    Swal.fire({
                        title: 'Erreur !',
                        text: error.message,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            }

            // Clic en dehors pour fermer la barre
            document.addEventListener('click', (e) => {
                if (!searchBox.contains(e.target) && searchInput.value.trim() === '') {
                    searchBox.classList.remove('active');
                }
            });

            searchBox.addEventListener('click', (e) => e.stopPropagation());

            // Charger les recherches récentes au démarrage
            refreshRecentSearches();
        });
    </script>
@endsection
