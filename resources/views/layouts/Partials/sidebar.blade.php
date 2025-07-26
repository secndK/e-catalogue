<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            {{-- <span class="align-middle">E-CATALOGUE</span> --}}
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu Principal
            </li>
            <li class="sidebar-item">
                @auth
                    <a class="sidebar-link" href="{{ route('catalogue') }}" data-bs-toggle="modal"
                        data-bs-target="#createAppModal">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span class="align-middle">Nouvelle Application </span>
                    </a>

                @endauth

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
