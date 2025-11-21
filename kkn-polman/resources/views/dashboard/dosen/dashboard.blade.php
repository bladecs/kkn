@extends('dashboard.dosen.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')

@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        const statusProject = @json($status_project ?? '-');
        (function() {
            const el = document.querySelector('.phase-step[data-phase="penerjunan"]');
            if (!el) return;

            el.classList.remove('complete', 'active');

            function setStatus(el, statusClass, text) {
                el.classList.add(statusClass);
                const statusEl = el.querySelector('.phase-status');
                if (statusEl) {
                    statusEl.className = 'phase-status ' +
                        (statusClass === 'complete' ? 'status-completed' :
                            (statusClass === 'active' ? 'status-active' : 'status-pending'));
                    statusEl.textContent = text;
                }
            }

            const s = (statusProject || '').toLowerCase().trim();

            if (['complete', 'selesai', 'done'].includes(s)) {
                setStatus(el, 'complete', 'Selesai');
            } else if (['active', 'berjalan', 'ongoing', 'pending'].includes(s)) {
                setStatus(el, 'active', 'Berjalan');
            } else {
                setStatus(el, '', 'Menunggu');
            }
        })();
    </script>

    <script>
        (function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(a => {
                setTimeout(() => {
                    try {
                        const bsAlert = bootstrap?.Alert?.getInstance(a) ?? new bootstrap.Alert(a);
                        bsAlert.close();
                    } catch (e) {
                        a.classList.remove('show');
                        a.style.display = 'none';
                    }
                }, 4000);
            });
        })();
    </script>
@endsection
