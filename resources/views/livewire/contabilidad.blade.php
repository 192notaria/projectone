
<div class="simple-pill">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link active" id="pills-home-icon-tab" data-bs-toggle="pill" data-bs-target="#pills-home-icon" type="button" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                <i class="fa-solid fa-building-columns"></i>
                Bancos
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button class="nav-link" id="categoria-gastos-tab" data-bs-toggle="pill" data-bs-target="#categoria-gastos" type="button" role="tab" aria-controls="categoria-gastos" aria-selected="false">
                <i class="fa-solid fa-money-bill-trend-up"></i>
                Categorias de gastos
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="conceptos-pago-tab" data-bs-toggle="pill" data-bs-target="#conceptos-pago" type="button" role="tab" aria-controls="conceptos-pago" aria-selected="false">
                <i class="fa-solid fa-money-bill"></i>
                Conceptos de pago
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="cuentas-contables-tab" data-bs-toggle="pill" data-bs-target="#cuentas-contables" type="button" role="tab" aria-controls="cuentas-contables" aria-selected="false">
                <i class="fa-solid fa-dollar-sign"></i>
                Cuentas contables
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="metodos-pago-tab" data-bs-toggle="pill" data-bs-target="#metodos-pago" type="button" role="tab" aria-controls="metodos-pago" aria-selected="false">
                <i class="fa-solid fa-money-check-dollar"></i>
                Metodos de pago
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="tipos-cuenta-tab" data-bs-toggle="pill" data-bs-target="#tipos-cuenta" type="button" role="tab" aria-controls="tipos-cuenta" aria-selected="false">
                <i class="fa-solid fa-receipt"></i>
                Tipos de cuentas
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="tipos-impuestos-tab" data-bs-toggle="pill" data-bs-target="#tipos-impuestos" type="button" role="tab" aria-controls="tipos-impuestos" aria-selected="false">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Tipos de impuestos
            </button>
        </li>
        <li class="nav-item" role="presentation" wire:ignore>
            <button wire:ignore class="nav-link" id="tipos-uso-cuentas-tab" data-bs-toggle="pill" data-bs-target="#tipos-uso-cuentas" type="button" role="tab" aria-controls="tipos-uso-cuentas" aria-selected="false">
                <i class="fa-solid fa-file-invoice"></i>
                Tipos de uso de cuentas
            </button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div wire:ignore.self class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-icon-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.bancos")
            @endif

            @if ($vista == "form-banco")
                @include("livewire.contabilidad-tabs.contabilidad-forms.bancos")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="categoria-gastos" role="tabpanel" aria-labelledby="categoria-gastos-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.categoria-gastos")
            @endif

            @if ($vista == "categoria-gastos-form")
                @include("livewire.contabilidad-tabs.contabilidad-forms.categoria-gastos")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="conceptos-pago" role="tabpanel" aria-labelledby="conceptos-pago-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.conceptos-pago")
            @endif

            @if ($vista == "concepto-pago-form")
                @include("livewire.contabilidad-tabs.contabilidad-forms.conceptos-pago")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="cuentas-contables" role="tabpanel" aria-labelledby="cuentas-contables-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.cuentas-contables")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="metodos-pago" role="tabpanel" aria-labelledby="metodos-pago-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.metodos-pago")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="tipos-cuenta" role="tabpanel" aria-labelledby="tipos-cuenta-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.tipos-cuentas")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="tipos-impuestos" role="tabpanel" aria-labelledby="tipos-impuestos-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.tipos-impuestos")
            @endif
        </div>
        <div wire:ignore.self class="tab-pane fade" id="tipos-uso-cuentas" role="tabpanel" aria-labelledby="tipos-uso-cuentas-tab" tabindex="0">
            @if ($vista == "home")
                @include("livewire.contabilidad-tabs.tipo-uso-cuentas")
            @endif
        </div>
    </div>
</div>
