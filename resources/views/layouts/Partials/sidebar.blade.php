<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            {{-- <span class="align-middle">E-CATALOGUE</span> --}}
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu Principal
            </li>

            {{-- <!-- Nouveau lien "Toutes les applications" -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('catalogue.all') }}" id="showAllApps">
                    <i class="bi bi-grid-fill"></i>
                    <span class="align-middle">Toutes les applications</span>
                </a>
            </li> --}}

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('accueil') }}" data-bs-toggle="modal"
                    data-bs-target="#createAppModal">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Nouvelle Application </span>
                </a>

                {{-- <a class="sidebar-link" href="{{ route('langages.get') }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Langage de Dev</span>
                </a>

                <a class="sidebar-link" href="{{ route('services.get') }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Service à monitorer</span>
                </a>

                <a class="sidebar-link" href="{{ route('os.get') }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Système d'exploitation</exploitation></span>
                </a>
                <a class="sidebar-link" href="{{ route('environnements.get') }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Environnement</span>
                </a> --}}
                {{-- <a class="sidebar-link" href="{{ route('applications.index') }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">app</span>
                </a> --}}
            </li>
        </ul>

        <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">E-CATALOGUE v1.0</strong>
                <div class="mb-3 text-sm">
                    Système de gestion des applications
                </div>
            </div>
        </div>
    </div>
</nav>
