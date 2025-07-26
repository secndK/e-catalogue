@extends('layouts.app')
@section('title', 'E-CATALOGUE')
@section('content')
    <div class="px-4 container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header avec lien admin -->
                <div class="d-flex justify-content-end align-items-center mb-4">


                    <!-- Lien Se connecter en tant qu'admin et apparait seulment que au personne qui ne sont pas connecté-->
                    @guest
                        <div class="admin-login-section">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-badge me-2"></i>Se connecter en tant qu'admin
                            </a>
                        </div>
                    @endguest



                </div>

                <form action="{{ route('catalogue') }}" method="POST" class="mb-4" id="searchForm">
                    @csrf
                    <div class="search-container">
                        <div class="search-box {{ !empty($search_query) ? 'active' : '' }}" id="searchBox">
                            <div class="search-icon" id="searchIcon">
                                <i class="bi bi-search"></i>
                            </div>
                            <input type="text" class="search-input" id="searchInput" name="rechercher"
                                placeholder="Rechercher une application..." value="{{ $search_query ?? '' }}">
                            <div class="close-btn" id="closeBtn">
                                <i class="bi bi-x"></i>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="search-results" id="searchResults">
                    @if (!empty($search_query))
                        @if ($catalogue->count() > 0)
                            <div class="result-count mb-3">
                                <span class="text-primary fw-bold">
                                    <i class="bi bi-check-circle-fill"></i> Résultats pour "{{ $search_query }}"
                                    <small class="text-muted ms-2">({{ $catalogue->count() }} résultat(s))</small>
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
                                                                data-app='@json($app)'>
                                                                <i class="bi bi-eye-fill me-2"></i>Détail
                                                            </button>
                                                        </li>
                                                        @auth
                                                            <li>
                                                                <button class="dropdown-item edit-app"
                                                                    data-app-id="{{ $app->id }}"
                                                                    data-app-data='@json($app)'
                                                                    data-bs-toggle="modal" data-bs-target="#editAppModal">
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
                                                        @endauth
                                                    </ul>
                                                </div>

                                                <!-- Nom de l'application -->
                                                <h5 class="card-title fw-bold text-dark mb-3">
                                                    <i class="bi bi-box-seam text-primary"></i> {{ $app->app_name }}
                                                </h5>

                                                <!-- Informations générales -->
                                                @if (!empty($app->url_app))
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-card-text me-2 text-muted"></i>
                                                        <small class="text-muted text-truncate">{{ $app->url_app }}</small>
                                                    </div>
                                                @endif

                                                <!-- Environnements -->
                                                <div class="environments-container mb-2">
                                                    @if (!empty($app->env_prod))
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span class="badge bg-success me-2">PROD</span>
                                                            <small class="text-muted">{{ $app->adr_serv_prod }}</small>
                                                        </div>
                                                    @endif

                                                    @if (!empty($app->env_test))
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span class="badge bg-warning text-dark me-2">TEST</span>
                                                            <small class="text-muted">{{ $app->adr_serv_test }}</small>
                                                        </div>
                                                    @endif

                                                    @if (!empty($app->env_dev))
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span class="badge bg-info text-dark me-2">DEV</span>
                                                            <small class="text-muted">{{ $app->adr_serv_dev }}</small>
                                                        </div>
                                                    @endif
                                                </div>

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
                                <i class="bi bi-collection text-muted" style="font-size: 3rem;"></i>
                                <h4 class="text-muted mt-3">Bienvenue sur le catalogue</h4>
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
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="appDetailsModalLabel">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Détails de l'application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="app-details-container">
                        <table class="table table-bordered table-striped">
                            <tbody id="appDetailsContent">
                                <!-- Contenu dynamique injecté ici -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Les modals de création et modification ne sont visibles que pour les admins connectés -->

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
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="desc_app" class="form-label fw-bold">
                                    <i class="bi bi-card-text me-1"></i> Description
                                </label>
                                <input type="text" class="form-control" id="desc_app" name="desc_app">
                            </div>
                            <div class="col-md-6">
                                <label for="url_app" class="form-label fw-bold">
                                    <i class="bi bi-link-45deg me-1"></i> URL Application
                                </label>
                                <input type="url" class="form-control" id="url_app" name="url_app">
                            </div>
                            <div class="col-md-6">
                                <label for="url_doc" class="form-label fw-bold">
                                    <i class="bi bi-journal-text me-1"></i> URL Documentation
                                </label>
                                <input type="url" class="form-control" id="url_doc" name="url_doc">
                            </div>
                            <div class="col-md-6">
                                <label for="url_git" class="form-label fw-bold">
                                    <i class="bi bi-git me-1"></i> URL Git
                                </label>
                                <input type="url" class="form-control" id="url_git" name="url_git">
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
                                    <label for="lang_deve_dev" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="lang_deve_dev" name="lang_deve_dev">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_dev" class="form-label">Service critique</label>
                                    <select id="critical_dev" name="critical_dev[]" class="form-control select-tags"
                                        multiple="multiple"></select>
                                </div>

                                <div class="col-md-12">
                                    <label for="statut_dev" class="form-label">Statut environnemnt Dev</label>
                                    <select id="statut_dev" name="statut_dev" class="form-control">
                                        <option value="Actif">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
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
                                    <label for="lang_deve_test" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="lang_deve_test"
                                        name="lang_deve_test">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_test" class="form-label">Service critique </label>
                                    <select id="critical_test" name="critical_test[]" class="form-control select-tags"
                                        multiple="multiple"></select>
                                </div>
                                <div class="col-md-12">
                                    <label for="statut_test" class="form-label">Statut environnemnt Test</label>
                                    <select id="statut_test" name="statut_test" class="form-control">
                                        <option value="Actif">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
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
                                    <label for="lang_deve_prod" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="lang_deve_prod"
                                        name="lang_deve_prod">
                                </div>
                                <div class="col-md-12">
                                    <label for="critical_prod" class="form-label">Service critique</label>
                                    <select id="critical_prod" name="critical_prod[]" class="form-control select-tags"
                                        multiple="multiple"></select>
                                </div>

                                <div class="col-md-12">
                                    <label for="statut_prod" class="form-label">Statut</label>
                                    <select id="statut_prod" name="statut_prod" class="form-control">
                                        <option value="Actif">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
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
                    @method('PUT')
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
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="edit_desc_app" class="form-label fw-bold">
                                    <i class="bi bi-card-text me-1"></i> Description
                                </label>
                                <input type="text" class="form-control" id="edit_desc_app" name="desc_app">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_url_app" class="form-label fw-bold">
                                    <i class="bi bi-link-45deg me-1"></i> URL Application
                                </label>
                                <input type="url" class="form-control" id="edit_url_app" name="url_app">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_url_doc" class="form-label fw-bold">
                                    <i class="bi bi-journal-text me-1"></i> URL Documentation
                                </label>
                                <input type="url" class="form-control" id="edit_url_doc" name="url_doc">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_url_git" class="form-label fw-bold">
                                    <i class="bi bi-git me-1"></i> URL Git
                                </label>
                                <input type="url" class="form-control" id="edit_url_git" name="url_git">
                            </div>
                        </div>

                        <!-- Environnement DEV -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-primary fw-bold mb-3">
                                <i class="bi bi-code-square me-1"></i> Environnement Développement
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="edit_env_dev" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_dev" name="env_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_dev" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_dev"
                                        name="adr_serv_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_dev" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_dev" name="sys_exp_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_bd_dev" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_dev"
                                        name="adr_serv_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_bd_dev" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_dev"
                                        name="sys_exp_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_lang_deve_dev" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_dev"
                                        name="lang_deve_dev">
                                </div>
                                <div class="col-md-12">
                                    <label for="edit_critical_dev" class="form-label">Criticité Dev</label>
                                    <select id="edit_critical_dev" name="critical_dev[]" class="form-control select-tags"
                                        multiple="multiple"></select>
                                </div>
                                <div class="col-md-12">
                                    <label for="edit_statut_dev" class="form-label">Statut Dev</label>
                                    <select id="edit_statut_dev" name="statut_dev" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Environnement TEST -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-warning fw-bold mb-3">
                                <i class="bi bi-bug me-1"></i> Environnement Test
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="edit_env_test" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_test" name="env_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_test" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_test"
                                        name="adr_serv_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_test" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_test"
                                        name="sys_exp_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_bd_test" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_test"
                                        name="adr_serv_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_bd_test" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_test"
                                        name="sys_exp_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_lang_deve_test" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_test"
                                        name="lang_deve_test">
                                </div>
                                <div class="col-md-12">
                                    <label for="edit_critical_test" class="form-label">Criticité Test</label>
                                    <select id="edit_critical_test" name="critical_test[]"
                                        class="form-control select-tags" multiple="multiple"></select>
                                </div>
                                <div class="col-md-12">
                                    <label for="edit_statut_test" class="form-label">Statut test</label>
                                    <select id="edit_statut_test" name="statut_test" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Environnement PROD -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-success fw-bold mb-3">
                                <i class="bi bi-check-circle me-1"></i> Environnement Production
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="edit_env_prod" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="edit_env_prod" name="env_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_prod" class="form-label">Adresse Serveur</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_prod"
                                        name="adr_serv_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_prod" class="form-label">OS Serveur</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_prod"
                                        name="sys_exp_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_adr_serv_bd_prod" class="form-label">Adresse BD</label>
                                    <input type="text" class="form-control" id="edit_adr_serv_bd_prod"
                                        name="adr_serv_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_sys_exp_bd_prod" class="form-label">OS BD</label>
                                    <input type="text" class="form-control" id="edit_sys_exp_bd_prod"
                                        name="sys_exp_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_lang_deve_prod" class="form-label">Langage de programation</label>
                                    <input type="text" class="form-control" id="edit_lang_deve_prod"
                                        name="lang_deve_prod">
                                </div>
                                <div class="col-md-12">
                                    <label for="edit_critical_prod" class="form-label">Criticité Prod</label>
                                    <select id="edit_critical_prod" name="critical_prod[]"
                                        class="form-control select-tags" multiple="multiple"></select>
                                </div>


                                <div class="col-md-12">
                                    <label for="edit_statut_prod" class="form-label">Statut Prod</label>
                                    <select id="edit_statut_prod" name="statut_prod" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
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
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.js"></script>

    <script>
        window.isAuth = @json(auth()->check());
    </script>
    <script>
        console.log('searchIcon:', searchIcon); // doit pas être null
        console.log('searchBox:', searchBox);
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const searchIcon = document.getElementById('searchIcon');
            const searchInput = document.getElementById('searchInput');
            const closeBtn = document.getElementById('closeBtn');
            const searchForm = document.getElementById('searchForm');
            const searchResults = document.getElementById('searchResults');
            const createForm = document.querySelector('#createAppModal form');
            const showAllAppsBtn = document.getElementById('showAllAppsBtn');
            const editAppModal = document.getElementById('editAppModal');

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
                console.log('Search icon clicked!');
                searchBox.classList.add('active');
                console.log('Search box should be active:', searchBox.classList.contains('active'));
                setTimeout(() => searchInput.focus(), 200);
            });

            // Fermer la barre de recherche
            closeBtn.addEventListener('click', () => {
                searchBox.classList.remove('active');
                searchInput.value = '';
                updateResults([], '');
                refreshRecentSearches();
            });

            // Clic en dehors pour fermer la barre
            document.addEventListener('click', (e) => {
                if (!searchBox.contains(e.target) && searchInput.value.trim() === '') {
                    searchBox.classList.remove('active');
                }
            });

            searchBox.addEventListener('click', (e) => e.stopPropagation());

            // Fonction pour attacher les événements aux recherches récentes
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
                    }, 700);
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
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Fonction pour masquer les recherches récentes
            function hideRecentSearches() {
                const sidebarNav = document.querySelector('.sidebar-nav');
                if (sidebarNav) {
                    sidebarNav.querySelectorAll('.recent-searches-header, .recent-search-item')
                        .forEach(el => el.style.display = 'none');
                }

                // Masquer aussi le bouton de suppression
                const clearBtnContainer = document.querySelector('.clear-searches-container');
                if (clearBtnContainer) {
                    clearBtnContainer.style.display = 'none';
                }
            }

            // Fonction pour afficher les recherches récentes
            function showRecentSearches() {
                const sidebarNav = document.querySelector('.sidebar-nav');
                if (sidebarNav) {
                    sidebarNav.querySelectorAll('.recent-searches-header, .recent-search-item')
                        .forEach(el => el.style.display = 'block');
                }

                // Afficher aussi le bouton de suppression
                const clearBtnContainer = document.querySelector('.clear-searches-container');
                if (clearBtnContainer) {
                    clearBtnContainer.style.display = 'block';
                }
            }

            // Fonction pour mettre à jour les résultats
            function updateResults(results, query) {
                let html = '';

                if (query && query.length > 0 && results.length > 0) {
                    // Afficher les résultats de recherche
                    html += `<div class="result-count mb-3">
                <span class="text-primary fw-bold">
                    <i class="bi bi-check-circle-fill"></i> Résultats pour "${query}"
                    <small class="text-muted ms-2">(${results.length} résultat(s))</small>
                </span>
            </div>
            <div class="row g-4" id="cardsContainer">`;

                    // Générer les cartes pour chaque résultat
                    results.forEach(app => {
                        const appDataJson = JSON.stringify(app).replace(/"/g, '&quot;');
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
                            <button class="dropdown-item view-app" data-bs-toggle="modal"
                                data-bs-target="#appDetailsModal"
                                data-app='${appDataJson}'>
                                <i class="bi bi-eye-fill me-2"></i>Détail
                            </button>
                        </li>
                        @auth
                        <li>
                            <button class="dropdown-item edit-app"
                                data-app-id="${app.id}"
                                data-app-data='${appDataJson}'
                                data-bs-toggle="modal" data-bs-target="#editAppModal">
                                <i class="bi bi-pencil-fill me-2"></i>Modifier
                            </button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button class="dropdown-item text-danger delete-app"
                                data-app-id="${app.id}"
                                data-app-name="${app.app_name}">
                                <i class="bi bi-trash-fill me-2"></i>Supprimer
                            </button>
                        </li>
                        @endauth
                    </ul>
                </div>

                <!-- Nom de l'application -->
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="bi bi-box-seam text-primary"></i> ${app.app_name || 'Application'}
                </h5>

                <!-- Informations générales -->
                ${app.url_app ? `
                                                                                                                    <div class="d-flex align-items-center mb-2">
                                                                                                                        <i class="bi bi-card-text me-2 text-muted"></i>
                                                                                                                        <small class="text-muted text-truncate">${app.url_app}</small>
                                                                                                                    </div>
                                                                                                                    ` : ''}

                <!-- Environnements -->
                <div class="environments-container mb-2">
                    ${app.env_prod ? `
                                                                                                                        <div class="d-flex align-items-center mb-1">
                                                                                                                            <span class="badge bg-success me-2">PROD</span>
                                                                                                                            <small class="text-muted">${app.adr_serv_prod || ''}</small>
                                                                                                                        </div>
                                                                                                                        ` : ''}

                    ${app.env_test ? `
                                                                                                                        <div class="d-flex align-items-center mb-1">
                                                                                                                            <span class="badge bg-warning text-dark me-2">TEST</span>
                                                                                                                            <small class="text-muted">${app.adr_serv_test || ''}</small>
                                                                                                                        </div>
                                                                                                                        ` : ''}

                    ${app.env_dev ? `
                                                                                                                        <div class="d-flex align-items-center mb-1">
                                                                                                                            <span class="badge bg-info text-dark me-2">DEV</span>
                                                                                                                            <small class="text-muted">${app.adr_serv_dev || ''}</small>
                                                                                                                        </div>
                                                                                                                        ` : ''}
                </div>
            </div>
        </div>
    </div>
                `;
                    });

                    html += '</div>';

                    // Masquer les recherches récentes seulement quand on a des résultats
                    // hideRecentSearches();

                } else if (query && query.length > 0) {
                    // Aucun résultat trouvé - afficher quand même les recherches récentes
                    html = `
                <div class="col-12 mt-0">
                    <div class="text-center py-5">
                        <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">Aucun résultat trouvé</h4>
                        <p class="text-muted">Essayez avec d'autres mots-clés</p>
                    </div>
                </div>`;

                    // Rafraîchir d'abord les recherches récentes puis les afficher
                    setTimeout(() => {
                        refreshRecentSearches().then(() => {
                            showRecentSearches();
                        });
                    }, 100);
                } else {
                    // Pas de recherche - afficher l'écran d'accueil
                    html = `
                <div class="col-12 mt-0">
                    <div class="text-center py-5">
                        <i class="bi bi-collection text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">Bienvenue sur le catalogue</h4>
                        <p class="text-muted">Utilisez la barre de recherche pour trouver les applications du catalogue</p>

                    </div>
                </div>`;

                    // Afficher les recherches récentes quand il n'y a pas de recherche active
                    showRecentSearches();
                }

                document.getElementById('searchResults').innerHTML = html;
            }

            // Modal des détails de l'application
            document.addEventListener('shown.bs.modal', function(event) {
                if (event.target.id === 'appDetailsModal') {
                    const button = event.relatedTarget;
                    const app = JSON.parse(button.getAttribute('data-app'));

                    // Fonctions helper pour générer le contenu
                    const section = (title, icon) => `
                <tr class="table-light">
                    <th colspan="2" class="text-primary">
                        <i class="bi ${icon} me-2"></i>${title}
                    </th>
                </tr>
            `;

                    const row = (label, value, icon = null) => {
                        const displayValue = value ? value : '<span class="text-muted">-</span>';
                        const iconHtml = icon ? `<i class="bi ${icon} me-2 text-muted"></i>` : '';
                        return `
                    <tr>
                        <th class="w-40">${iconHtml}${label}</th>
                        <td class="w-60">${displayValue}</td>
                    </tr>
                `;
                    };

                    // Formatage des données critiques
                    const formatCritical = (critical) => {
                        if (!critical) return null;
                        try {
                            const critArray = typeof critical === 'string' ? JSON.parse(critical) :
                                critical;

                            if (Array.isArray(critArray)) {
                                return critArray.map(item =>
                                    `<span class="badge bg-danger me-1">${item}</span>`
                                ).join(' ');
                            }

                            return `<span class="badge bg-danger">${critical}</span>`;
                        } catch {
                            return `<span class="badge bg-danger">${critical}</span>`;
                        }
                    };


                    // Génération du contenu
                    const detailsBody = document.getElementById('appDetailsContent');
                    detailsBody.innerHTML = `
                ${section('Informations Générales', 'bi-box-seam')}
                ${row("Nom de l'application", app.app_name, 'bi-box-seam')}
                ${row("Description", app.desc_app, 'bi-card-text')}
                ${row("URL Application", app.url_app ? `<a href="${app.url_app}" target="_blank">${app.url_app}</a>` : null, 'bi-link-45deg')}
                ${row("URL Documentation", app.url_doc ? `<a href="${app.url_doc}" target="_blank">${app.url_doc}</a>` : null, 'bi-journal-text')}
                ${row("URL Git", app.url_git ? `<a href="${app.url_git}" target="_blank">${app.url_git}</a>` : null, 'bi-git')}

                ${section('Environnement Développement', 'bi-code-square')}
                ${row("Nom environnement", app.env_dev, 'bi-tag')}
                ${row("Adresse Serveur", app.adr_serv_dev, 'bi-hdd-network')}
                ${row("OS Serveur", app.sys_exp_dev, 'bi-cpu')}
                ${row("Adresse BD", app.adr_serv_bd_dev, 'bi-database')}
                ${row("OS BD", app.sys_exp_bd_dev, 'bi-hdd')}
                ${row("Langage de programation", app.lang_dev || app.lang_deve_dev, 'bi-code-slash')}
                ${row("Service critique", formatCritical(app.critical_dev), 'bi-exclamation-triangle')}
                ${row("Statut", app.statut_dev, 'bi-triangle')}

                ${section('Environnement Test', 'bi-bug')}
                ${row("Nom environnement", app.env_test, 'bi-tag')}
                ${row("Adresse Serveur", app.adr_serv_test, 'bi-hdd-network')}
                ${row("OS Serveur", app.sys_exp_test, 'bi-cpu')}
                ${row("Adresse BD", app.adr_serv_bd_test, 'bi-database')}
                ${row("OS BD", app.sys_exp_bd_test, 'bi-hdd')}
                ${row("Langage de programation", app.lang_dev || app.lang_deve_test, 'bi-code-slash')}
                ${row("Service Critique", formatCritical(app.critical_test), 'bi-exclamation-triangle')}
                ${row("Statut", app.statut_test, 'bi-triangle')}

                ${section('Environnement Production', 'bi-check-circle')}
                ${row("Nom environnement", app.env_prod, 'bi-tag')}
                ${row("Adresse Serveur", app.adr_serv_prod, 'bi-hdd-network')}
                ${row("OS Serveur", app.sys_exp_prod, 'bi-cpu')}
                ${row("Adresse BD", app.adr_serv_bd_prod, 'bi-database')}
                ${row("OS BD", app.sys_exp_bd_prod, 'bi-hdd')}
                ${row("Langage de programation", app.lang_dev || app.lang_deve_prod, 'bi-code-slash')}
                ${row("Service critique", formatCritical(app.critical_prod), 'bi-exclamation-triangle')}
                ${row("Statut", app.statut_prod, 'bi-triangle')}
            `;
                }
            });

            // Rafraîchir les recherches récentes dans la sidebar
            function refreshRecentSearches() {
                return fetch('{{ route('get.recent.searches') }}', {
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

                                // Vérifier si le bouton existe déjà avant de le recréer
                                let clearBtnContainer = document.querySelector('.clear-searches-container');

                                // Point d'insertion pour les recherches
                                const menuItem = sidebarNav.querySelector('.sidebar-item');

                                // Créer le bouton s'il n'existe pas ET s'il y a des recherches
                                if (!clearBtnContainer && data.recent_searches.length > 0) {
                                    const sidebarCta = document.querySelector(
                                        '.sidebar-cta .sidebar-cta-content');
                                    if (sidebarCta) {
                                        clearBtnContainer = document.createElement('div');
                                        clearBtnContainer.className =
                                            'clear-searches-container mt-2 text-center';
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
                                }

                                // Afficher les recherches seulement s'il y en a
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

                                    // S'assurer que le bouton est visible
                                    if (clearBtnContainer) {
                                        clearBtnContainer.style.display = 'block';
                                    }
                                } else if (clearBtnContainer) {
                                    // Masquer le bouton s'il n'y a pas de recherches
                                    clearBtnContainer.style.display = 'none';
                                }

                                attachRecentSearchEvents();
                            }
                        }
                        return data;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        return {
                            success: false
                        };
                    });
            }


            //creer les donner
            if (createForm) {
                // Initialisation des Select2 pour les champs critiques
                $(document).ready(function() {
                    $('.select-tags').select2({
                        tags: true,
                        tokenSeparators: [','],
                        width: '100%',
                        placeholder: 'Sélectionnez ou ajoutez des tags',
                        allowClear: true
                    });
                });

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

                    // Récupérer les données des Select2
                    const formData = new FormData(this);
                    const criticalFields = ['critical_dev', 'critical_test', 'critical_prod'];

                    criticalFields.forEach(field => {
                        const selectElement = $(`#${field}`);
                        if (selectElement.length) {
                            const selectedValues = selectElement.select2('val');
                            if (selectedValues && selectedValues.length > 0) {
                                // Supprimer l'ancienne valeur avant d'ajouter les nouvelles
                                formData.delete(field + '[]');
                                selectedValues.forEach(val => {
                                    formData.append(field + '[]', val);
                                });
                            }
                        }
                    });

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
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

                                // Réinitialiser les Select2
                                $('.select-tags').val(null).trigger('change');

                                // Afficher SweetAlert de succès avec animation
                                Swal.fire({
                                    title: 'Application enrégistrée avec succès !',
                                    icon: 'success',
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

            // ===== ÉDITION D'APPLICATION =====
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-app')) {
                    const button = e.target.closest('.edit-app');
                    const appId = button.dataset.appId;
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
                            if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success) throw new Error(data.message || 'Erreur inconnue');

                            // Restaurer le contenu du modal
                            modalBody.innerHTML = originalContent;
                            const appData = data.data;

                            // Remplir les champs simples
                            const simpleFields = [
                                'app_name', 'desc_app', 'url_app', 'url_doc', 'url_git',
                                'env_dev', 'adr_serv_dev', 'sys_exp_dev', 'adr_serv_bd_dev',
                                'sys_exp_bd_dev', 'lang_deve_dev', 'statut_dev',
                                'env_prod', 'adr_serv_prod', 'sys_exp_prod', 'adr_serv_bd_prod',
                                'sys_exp_bd_prod', 'lang_deve_prod', 'statut_prod',
                                'env_test', 'adr_serv_test', 'sys_exp_test', 'adr_serv_bd_test',
                                'sys_exp_bd_test', 'lang_deve_test', 'statut_test'
                            ];

                            simpleFields.forEach(field => {
                                const element = document.getElementById(`edit_${field}`);
                                if (element) element.value = appData[field] || '';
                            });

                            // Fonction optimisée pour initialiser Select2 sans duplication
                            const initSelect2 = (id, values) => {
                                const element = $(`#edit_${id}`);
                                if (!element.length) return;

                                // Nettoyage complet de Select2
                                if (element.hasClass('select2-hidden-accessible')) {
                                    element.select2('destroy');
                                    element.removeClass('select2-hidden-accessible');
                                    element.next('.select2-container').remove();
                                }

                                // Parser les valeurs
                                let parsedValues = [];
                                try {
                                    if (values) {
                                        parsedValues = typeof values === 'string' ?
                                            JSON.parse(values || '[]') :
                                            (Array.isArray(values) ? values : [values]);
                                        // Supprimer les doublons
                                        parsedValues = [...new Set(parsedValues.filter(v => v && v
                                            .trim() !== ''))];
                                    }
                                } catch (e) {
                                    console.error(`Erreur parsing ${id}:`, e);
                                    parsedValues = [];
                                }

                                // Réinitialiser complètement le select
                                element.empty();

                                // Initialiser Select2 avec les valeurs uniques
                                element.select2({
                                    width: '100%',
                                    placeholder: 'Ajouter des services',
                                    tags: true,
                                    tokenSeparators: [',', ' '],
                                    data: parsedValues.map(value => ({
                                        id: value,
                                        text: value
                                    }))
                                });

                                // Définir les valeurs si elles existent
                                if (parsedValues.length > 0) {
                                    element.val(parsedValues).trigger('change');
                                }
                            };

                            // Initialiser les champs critiques
                            ['critical_dev', 'critical_test', 'critical_prod'].forEach(field => {
                                initSelect2(field, appData[field]);
                            });

                            document.getElementById('edit_app_id').value = appData.id;
                            const form = document.getElementById('editAppForm');
                            form.action = `/catalogue/${appData.id}`;
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
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

            // ===== SOUMISSION DU FORMULAIRE MISE À JOUR =====
            document.getElementById('editAppForm')?.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                // Gestion optimisée des champs Select2
                const processSelect2Field = (fieldName) => {
                    const selectElement = $(`#edit_${fieldName}`);
                    if (selectElement.length) {
                        // Supprimer tous les anciens inputs cachés
                        form.querySelectorAll(`input[name^="${fieldName}"]`).forEach(el => el.remove());

                        // Récupérer les valeurs uniques
                        const selectedValues = [...new Set(selectElement.select2('val') || [])];

                        // Ajouter les nouvelles valeurs comme champs cachés
                        selectedValues.forEach(value => {
                            if (value && value.trim() !== '') {
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = `${fieldName}[]`;
                                hiddenInput.value = value;
                                form.appendChild(hiddenInput);
                            }
                        });
                    }
                };

                // Traiter tous les champs critiques
                ['critical_dev', 'critical_test', 'critical_prod'].forEach(processSelect2Field);

                // État du bouton pendant le chargement
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>
        <span role="status">Enregistrement...</span>
    `;

                // Notification de chargement
                Swal.fire({
                    title: 'Mise à jour en cours',
                    html: `
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-2">Veuillez patienter pendant la mise à jour...</p>
            </div>
        `,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    backdrop: true
                });

                // Préparation des données
                const formData = new FormData(form);

                // Envoi de la requête
                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422) {
                                const errors = data.errors ? Object.entries(data.errors)
                                    .map(([field, messages]) => `${messages.join(', ')}`)
                                    .join('\n') : data.message;
                                throw new Error(errors || 'Erreur de validation');
                            }
                            throw new Error(data.message || `Erreur serveur: ${response.status}`);
                        }

                        if (!data.success) {
                            throw new Error(data.message || 'Échec de la mise à jour');
                        }

                        return data;
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Mise à jour réussie !',
                            text: data.message || 'Les modifications ont été enregistrées',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Fermer',
                            confirmButtonColor: '#28a745',
                            timer: 3000,
                            timerProgressBar: true,
                            willClose: () => {
                                const editModal = bootstrap.Modal.getInstance(document
                                    .getElementById('editAppModal'));
                                editModal.hide();
                                location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors de la mise à jour:', error);

                        Swal.fire({
                            title: 'Erreur lors de la mise à jour',
                            html: `
                    <div class="text-danger mb-3">
                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                        <p class="mt-2">${error.message}</p>
                    </div>
                    <small class="text-muted">Vérifiez les données et réessayez</small>
                `,
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Compris'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
            });


            // ======================== SUPPRIMER UNE APPP=======================================
            // Fonction pour supprimer une application via AJAX
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

            // Initialiser les recherches récentes au chargement
            refreshRecentSearches();
        });
    </script>
@endsection
