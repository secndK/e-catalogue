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
                            <div class="search-icon" id="searchIcon">🔍</div>
                            <input type="text" class="search-input" id="searchInput" name="rechercher"
                                placeholder="Rechercher une application..." value="{{ $search_query ?? '' }}">
                            <div class="close-btn" id="closeBtn">✕</div>
                        </div>
                    </div>
                </form>


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
                                @foreach ($catalogue as $index => $app)
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
                                                            <button class="dropdown-item edit-app" data-bs-toggle="modal"
                                                                data-bs-target="#editAppModal"
                                                                data-app-id="{{ $app->id }}">
                                                                <i class="bi bi-pencil-fill me-2"></i>Modifier
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger delete-app"
                                                                data-app-id="{{ $app->id }}">
                                                                <i class="bi bi-trash-fill me-2"></i>Supprimer
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <h5 class="card-title fw-bold text-dark mb-3">
                                                    <i class="bi bi-box-seam text-primary"></i> {{ $app->app_name }}
                                                </h5>

                                                @if (isset($app->adr_serv))
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-hdd-network me-2 text-muted"></i>
                                                        <small class="text-muted">{{ $app->adr_serv }}</small>
                                                    </div>
                                                @endif

                                                @if (isset($app->adr_serv))
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-success me-2">SERVER</span>
                                                        <small class="text-muted">{{ $app->adr_serv }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                                    <h4 class="text-muted mt-3">Aucun résultat trouvé</h4>
                                    <p class="text-muted">Essayez avec d'autres mots-clés</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <p class="text-muted">Utilisez la barre de recherche pour trouver des applications</p>
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
    <div class="modal fade" id="createAppModal" tabindex="-1" aria-labelledby="createAppModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="createAppModalLabel">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                        Nouvelle Application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('catalogue.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="createAppErrors" class="alert alert-danger d-none" role="alert"></div>
                        <div class="row g-3">
                            <!-- Ligne 1 -->
                            <div class="col-md-6">
                                <label for="app_name" class="form-label">
                                    <i class="bi bi-box-seam me-1"></i> Nom de l'application*
                                </label>
                                <input type="text" class="form-control" id="app_name" name="app_name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="adr_serv" class="form-label">
                                    <i class="bi bi-hdd-network me-1"></i> Adresse Serveur*
                                </label>
                                <input type="text" class="form-control" id="adr_serv" name="adr_serv" required>
                            </div>

                            <!-- Ligne 2 -->
                            <div class="col-md-4">
                                <label for="env_dev" class="form-label">
                                    <i class="bi bi-code-square me-1"></i> Environnement DEV*
                                </label>
                                <input type="text" class="form-control" id="env_dev" name="env_dev" required>
                            </div>

                            <div class="col-md-4">
                                <label for="env_test" class="form-label">
                                    <i class="bi bi-bug me-1"></i> Environnement TEST*
                                </label>
                                <input type="text" class="form-control" id="env_test" name="env_test" required>
                            </div>

                            <div class="col-md-4">
                                <label for="env_prod" class="form-label">
                                    <i class="bi bi-check-circle me-1"></i> Environnement PROD*
                                </label>
                                <input type="text" class="form-control" id="env_prod" name="env_prod" required>
                            </div>

                            <!-- Ligne 3 -->
                            <div class="col-md-6">
                                <label for="sys_exp" class="form-label">
                                    <i class="bi bi-pc me-1"></i> Système d'exploitation*
                                </label>
                                <input type="text" class="form-control" id="sys_exp" name="sys_exp" required>
                            </div>

                            <div class="col-md-6">
                                <label for="lang_dev" class="form-label">
                                    <i class="bi bi-file-code me-1"></i> Langage de développement*
                                </label>
                                <input type="text" class="form-control" id="lang_dev" name="lang_dev" required>
                            </div>

                            <!-- Ligne 4 -->
                            <div class="col-md-6">
                                <label for="adr_serv_bd" class="form-label">
                                    <i class="bi bi-database me-1"></i> Adresse Base de Données*
                                </label>
                                <input type="text" class="form-control" id="adr_serv_bd" name="adr_serv_bd" required>
                            </div>

                            <div class="col-md-6">
                                <label for="sys_exp_bd" class="form-label">
                                    <i class="bi bi-server me-1"></i> Système Base de Données*
                                </label>
                                <input type="text" class="form-control" id="sys_exp_bd" name="sys_exp_bd" required>
                            </div>

                            <!-- Ligne 5 -->
                            <div class="col-12">
                                <label for="critical" class="form-label">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Criticité
                                </label>
                                <select class="form-select" id="critical" name="critical">
                                    <option value="">Non définie</option>
                                    <option value="Critique">Critique</option>
                                    <option value="Haute">Haute</option>
                                    <option value="Moyenne">Moyenne</option>
                                    <option value="Faible">Faible</option>
                                </select>
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
    <div class="modal fade" id="editAppModal" tabindex="-1" aria-labelledby="editAppModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editAppModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Modifier Application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAppForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_app_id" name="id">
                    <div class="modal-body">
                        <div id="editAppErrors" class="alert alert-danger d-none" role="alert"></div>
                        <div class="row g-3">
                            <!-- Ligne 1 -->
                            <div class="col-md-6">
                                <label for="edit_app_name" class="form-label">
                                    <i class="bi bi-box-seam me-1"></i> Nom de l'application*
                                </label>
                                <input type="text" class="form-control" id="edit_app_name" name="app_name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_adr_serv" class="form-label">
                                    <i class="bi bi-hdd-network me-1"></i> Adresse Serveur*
                                </label>
                                <input type="text" class="form-control" id="edit_adr_serv" name="adr_serv" required>
                            </div>

                            <!-- Ligne 2 -->
                            <div class="col-md-4">
                                <label for="edit_env_dev" class="form-label">
                                    <i class="bi bi-code-square me-1"></i> Environnement DEV*
                                </label>
                                <input type="text" class="form-control" id="edit_env_dev" name="env_dev" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_env_test" class="form-label">
                                    <i class="bi bi-bug me-1"></i> Environnement TEST*
                                </label>
                                <input type="text" class="form-control" id="edit_env_test" name="env_test" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_env_prod" class="form-label">
                                    <i class="bi bi-check-circle me-1"></i> Environnement PROD*
                                </label>
                                <input type="text" class="form-control" id="edit_env_prod" name="env_prod" required>
                            </div>

                            <!-- Ligne 3 -->
                            <div class="col-md-6">
                                <label for="edit_sys_exp" class="form-label">
                                    <i class="bi bi-pc me-1"></i> Système d'exploitation*
                                </label>
                                <input type="text" class="form-control" id="edit_sys_exp" name="sys_exp" required>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_lang_dev" class="form-label">
                                    <i class="bi bi-file-code me-1"></i> Langage de développement*
                                </label>
                                <input type="text" class="form-control" id="edit_lang_dev" name="lang_dev" required>
                            </div>

                            <!-- Ligne 4 -->
                            <div class="col-md-6">
                                <label for="edit_adr_serv_bd" class="form-label">
                                    <i class="bi bi-database me-1"></i> Adresse Base de Données*
                                </label>
                                <input type="text" class="form-control" id="edit_adr_serv_bd" name="adr_serv_bd"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="edit_sys_exp_bd" class="form-label">
                                    <i class="bi bi-server me-1"></i> Système Base de Données*
                                </label>
                                <input type="text" class="form-control" id="edit_sys_exp_bd" name="sys_exp_bd"
                                    required>
                            </div>

                            <!-- Ligne 5 -->
                            <div class="col-12">
                                <label for="edit_critical" class="form-label">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Criticité
                                </label>
                                <select class="form-select" id="edit_critical" name="critical">
                                    <option value="">Non définie</option>
                                    <option value="Critique">Critique</option>
                                    <option value="Haute">Haute</option>
                                    <option value="Moyenne">Moyenne</option>
                                    <option value="Faible">Faible</option>
                                </select>
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





@endsection

@section('script')
    <!-- Bootstrap Bundle with Popper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.js"
        integrity="sha512-oGPdYZUv人不            integrity="
        sha512-oGPdYZUvNyDCQh0iiS1m6hXB8ZfpjI8hKZdLVJVJZJzJLjn5q0/+qF6mNYWrF8PdQy3vZDUe6nqvlbV5kY6+g=="
                                                                                                                                                                                                                                        crossorigin="
        anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const searchIcon = document.getElementById('searchIcon');
            const searchInput = document.getElementById('searchInput');
            const closeBtn = document.getElementById('closeBtn');
            const searchForm = document.getElementById('searchForm');
            const searchResults = document.getElementById('searchResults');
            const createForm = document.querySelector('#createAppModal form');
            // NOUVELLE LIGNE : Vider le champ de recherche au chargement de la page
            searchInput.value = '';

            // Handle flash messages for non-AJAX submissions
            @if (session('success'))
                Swal.fire({
                    title: 'Parfait !',
                    html: `
                        <div class="text-center">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            <br><br>
                            <strong>{{ session('success') }}</strong>

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
                    }, 1500);
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
                                                    <button class="dropdown-item text-danger delete-app" data-app-id="${item.id}">
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

                                        ${item.env_prod ? `
                                                                                                                                                                                                                                                                            <div class="d-flex align-items-center">
                                                                                                                                                                                                                                                                                <span class="badge bg-success me-2">PROD</span>
                                                                                                                                                                                                                                                                                <small class="text-muted">${item.env_prod}</small>
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

            // Handle form submission for createAppModal
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
                                    confirmButtonText: 'Voir le résultat',
                                    confirmButtonColor: '#28a745',

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

            document.addEventListener('click', function(event) {
                const editButton = event.target.closest('.edit-app');
                if (editButton) {
                    const appId = editButton.getAttribute('data-app-id');

                    // Récupérer les données de l'application via AJAX
                    fetch(`/catalogue/${appId}/edit`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success || !data.data) {
                                throw new Error('Données invalides');
                            }

                            const app = data.data;

                            // Remplir le formulaire
                            document.getElementById('edit_app_id').value = app.id;
                            document.getElementById('edit_app_name').value = app.app_name;
                            document.getElementById('edit_adr_serv').value = app.adr_serv;
                            document.getElementById('edit_env_dev').value = app.env_dev;
                            document.getElementById('edit_env_test').value = app.env_test;
                            document.getElementById('edit_env_prod').value = app.env_prod;
                            document.getElementById('edit_sys_exp').value = app.sys_exp;
                            document.getElementById('edit_lang_dev').value = app.lang_dev;
                            document.getElementById('edit_adr_serv_bd').value = app.adr_serv_bd;
                            document.getElementById('edit_sys_exp_bd').value = app.sys_exp_bd;
                            document.getElementById('edit_critical').value = app.critical ?? '';

                            // Définir l'action du formulaire
                            document.getElementById('editAppForm').action = `/catalogue/${app.id}`;

                            // Afficher le modal
                            const modal = new bootstrap.Modal(document.getElementById('editAppModal'));
                            modal.show();
                        })

                        .catch(error => {
                            console.error('Error fetching app data for edit:', error);
                            Swal.fire({
                                title: 'Erreur de chargement !',
                                text: 'Impossible de récupérer les données de l\'application pour l\'édition.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545',
                            });
                        });
                }
            });

            // Handle app details modal
            document.addEventListener('shown.bs.modal', function(event) {
                if (event.target.id === 'appDetailsModal') {
                    const button = event.relatedTarget;
                    const app = JSON.parse(button.getAttribute('data-app'));

                    const detailsBody = document.getElementById('appDetailsContent');
                    detailsBody.innerHTML = `
                        <tr><th>Nom de l'application</th><td>${app.app_name || '-'}</td></tr>
                        <tr><th>Adresse Serveur</th><td>${app.adr_serv || '-'}</td></tr>
                        <tr><th>Système d'exploitation</th><td>${app.sys_exp || '-'}</td></tr>
                        <tr><th>Adresse BD</th><td>${app.adr_serv_bd || '-'}</td></tr>
                        <tr><th>Système BD</th><td>${app.sys_exp_bd || '-'}</td></tr>
                        <tr><th>Langage de Développement</th><td>${app.lang_dev || '-'}</td></tr>
                        <tr><th>Environnement DEV</th><td>${app.env_dev || '-'}</td></tr>
                        <tr><th>Environnement TEST</th><td>${app.env_test || '-'}</td></tr>
                        <tr><th>Environnement PROD</th><td>${app.env_prod || '-'}</td></tr>
                        <tr><th>Criticité</th><td>${app.critical || '-'}</td></tr>
                    `;
                }
            });

            document.getElementById('editAppForm').addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirmer la modification',
                    text: "Es-tu sûr de vouloir enregistrer ces changements ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, modifier',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = e.target;
                        const appId = document.getElementById('edit_app_id').value;
                        const url = `/catalogue/${appId}`;
                        const formData = new FormData(form);

                        // Nettoyer erreurs précédentes
                        const errorDiv = document.getElementById('editAppErrors');
                        errorDiv.classList.add('d-none');
                        errorDiv.innerHTML = '';

                        fetch(url, {
                                method: 'POST', // Laravel acceptera via _method
                                headers: {
                                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')
                                        .value,
                                },
                                body: formData,
                            })
                            .then(response => {
                                if (!response.ok) throw response;
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    bootstrap.Modal.getInstance(document.getElementById(
                                        'editAppModal')).hide();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Modification réussie !',
                                        text: 'L\'application a été mise à jour.',
                                        confirmButtonColor: '#0d6efd',
                                    }).then(() => {
                                        location
                                            .reload(); // Optionnel : mettre à jour dynamiquement
                                    });
                                } else {
                                    throw new Error(data.message || 'Erreur inconnue');
                                }
                            })
                            .catch(async error => {
                                let message = 'Erreur lors de la modification.';
                                if (error instanceof Response) {
                                    const errData = await error.json();
                                    if (errData.errors) {
                                        message = Object.values(errData.errors).flat().join(
                                            '<br>');
                                    } else if (errData.message) {
                                        message = errData.message;
                                    }
                                }

                                errorDiv.innerHTML = message;
                                errorDiv.classList.remove('d-none');
                            });
                    }
                });
            });



            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-app')) {
                    const appId = e.target.closest('.delete-app').getAttribute('data-app-id');

                    Swal.fire({
                        title: 'Confirmer la suppression',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/catalogue/${appId}/delete`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Supprimée !', data.message, 'success');
                                        // Optionnel : retirer la carte du DOM
                                        document.querySelector(`[data-app-id="${appId}"]`)
                                            .closest('.card').remove();
                                    } else {
                                        Swal.fire('Erreur', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire('Erreur', 'Erreur serveur.', 'error');
                                });
                        }
                    });
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
                                sidebarNav.querySelectorAll('.recent-searches-header, .recent-search-item')
                                    .forEach(el => el.remove());

                                // Point d’insertion
                                const menuItem = sidebarNav.querySelector('.sidebar-item');

                                if (menuItem && data.recent_searches.length > 0) {
                                    // Titre
                                    const recentHeader = document.createElement('li');
                                    recentHeader.className = 'sidebar-header recent-searches-header';
                                    recentHeader.innerHTML = `
                                        Recherches Récentes
                                        <i class="bi bi-clock-history float-end"></i>
                                    `;
                                    sidebarNav.insertBefore(recentHeader, menuItem.nextSibling);

                                    // Résultats
                                    data.recent_searches.forEach(search => {
                                        const recentItem = document.createElement('li');
                                        recentItem.className = 'sidebar-item recent-search-item';
                                        recentItem.innerHTML = `
                                            <a class="sidebar-link recent-search-link" href="#" data-search="${search.search_term}">
                                                <i class="bi bi-search"></i>
                                                <span class="align-middle">${search.search_term}</span>
                                                <span class="badge bg-primary rounded-pill float-end">${search.results_count}</span>
                                            </a>`;
                                        sidebarNav.insertBefore(recentItem, recentHeader.nextSibling);
                                    });
                                }

                                attachRecentSearchEvents();
                            }
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
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
