<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">E-CATALOGUE</span>
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
                <a class="sidebar-link" href="#" data-bs-toggle="modal" data-bs-target="#createAppModal">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span class="align-middle">Nouvelle Application</span>
                </a>
            </li>
            <!-- La section des recherches récentes sera injectée dynamiquement -->
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
