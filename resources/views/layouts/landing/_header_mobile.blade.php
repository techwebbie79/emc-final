<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <a href="{{ url('dashboard') }}">
        <img height="40" alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}" />
    </a>
    <div class="d-flex align-items-center">
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon2 svg-icon-xl">
                <i class="fas fa-user"></i>
            </span>
        </button>
    </div>
</div>
