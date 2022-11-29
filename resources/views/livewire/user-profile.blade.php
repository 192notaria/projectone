<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h2>Perfil de usuario</h2>
                        <div class="animated-underline-content">
                            <ul class="nav nav-tabs" id="animateLine" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="animated-underline-home-tab" data-bs-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="true">
                                        <i class="fa-solid fa-house"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="animated-underline-profile-tab" data-bs-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="false">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                        Domicilio
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form class="section general-info">
                                    <div class="info">
                                        <h6 class="">Informacion General</h6>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                                        <div class="profile-image  mt-4 pe-md-4">
                                                            <div class="img-uploader-content">
                                                                <input id="filepondid" wire:model='user_img' type="file" class="filepond" name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="fullName">Nombre</label>
                                                                        <input wire:model='nombre' type="text" class="form-control mb-3" id="fullName" placeholder="Full Name" value="{{auth()->user()->name}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="profession">Apellido Paterno</label>
                                                                        <input wire:model='apaterno' type="text" class="form-control mb-3" id="fullName" placeholder="Full Name" value="{{auth()->user()->apaterno}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="profession">Apellido Materno</label>
                                                                        <input wire:model='amaterno' type="text" class="form-control mb-3" id="fullName" placeholder="Full Name" value="{{auth()->user()->amaterno}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="country">Genero</label>
                                                                        <select wire:model='genero' class="form-select mb-3" id="country" value="{{auth()->user()->genero}}">
                                                                            <option disabled>Seleccionar...</option>
                                                                            <option value="MASCULINO">MASCULINO</option>
                                                                            <option value="FEMENINO">FEMENINO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="country">Ocupacion</label>
                                                                        <select wire:model='ocupacion' class="form-select mb-3" id="country" value="{{auth()->user()->ocupacion}}">
                                                                            <option disabled>Seleccionar...</option>
                                                                            @foreach ($ocupaciones as $ocupacion)
                                                                                <option value="{{$ocupacion->id}}">{{$ocupacion->nombre}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="country">Fecha de nacimiento</label>
                                                                        <input wire:model='fecha_nacimiento' type="date" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="phone">Telefono</label>
                                                                        <input wire:model='telefono' type="number" class="form-control mb-3" id="phone" placeholder="Write your phone number here" value="{{auth()->user()->telefono}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">Email</label>
                                                                        <input type="text" class="form-control mb-3" id="email" placeholder="Write your email here" value="{{auth()->user()->email}}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">Contraseña</label>
                                                                        <input wire:model='contraseña' type="text" class="form-control mb-3" id="email" placeholder="Write your email here" value="{{auth()->user()->email}}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">Confirmacion de contraseña</label>
                                                                        <input wire:model='confirmacion_contraseña' type="text" class="form-control mb-3" id="email" placeholder="Write your email here" value="{{auth()->user()->email}}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-1">
                                                                    <div class="form-group text-end">
                                                                        <button type="button" wire:click='saveData' class="btn btn-secondary">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                        {{-- <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                <div class="section general-info payment-info">
                                    <div class="info">
                                        <h6 class="">Billing Address</h6>
                                        <p>Changes to your <span class="text-success">Billing</span> information will take effect starting with scheduled payment and will be refelected on your next invoice.</p>

                                        <div class="list-group mt-4">
                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress1" checked>
                                                        </div>
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">Address #1</div>
                                                        <p>2249 Caynor Circle, New Brunswick, New Jersey</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress2">
                                                        </div>
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">Address #2</div>
                                                        <p>4262 Leverton Cove Road, Springfield, Massachusetts</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>
                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress3">
                                                        </div>
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">Address #3</div>
                                                        <p>2692 Berkshire Circle, Knoxville, Tennessee</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <button class="btn btn-secondary mt-4 add-address">Add Address</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                <div class="section general-info payment-info">
                                    <div class="info">
                                        <h6 class="">Payment Method</h6>
                                        <p>Changes to your <span class="text-success">Payment Method</span> information will take effect starting with scheduled payment and will be refelected on your next invoice.</p>

                                        <div class="list-group mt-4">

                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod1">
                                                        </div>
                                                    </div>
                                                    <div class="payment-card">
                                                        <img src="../src/assets/img/card-mastercard.svg" class="align-self-center me-3" alt="americanexpress">
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">Mastercard</div>
                                                        <p>XXXX XXXX XXXX 9704</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>
                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod2" checked>
                                                        </div>
                                                    </div>
                                                    <div class="payment-card">
                                                        <img src="../src/assets/img/card-americanexpress.svg" class="align-self-center me-3" alt="americanexpress">
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">American Express</div>
                                                        <p>XXXX XXXX XXXX 310</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>
                                            <label class="list-group-item">
                                                <div class="d-flex w-100">
                                                    <div class="billing-radio me-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod3">
                                                        </div>
                                                    </div>
                                                    <div class="payment-card">
                                                        <img src="../src/assets/img/card-visa.svg" class="align-self-center me-3" alt="americanexpress">
                                                    </div>
                                                    <div class="billing-content">
                                                        <div class="fw-bold">Visa</div>
                                                        <p>XXXX XXXX XXXX 5264</p>
                                                    </div>
                                                    <div class="billing-edit align-self-center ms-auto">
                                                        <button class="btn btn-dark">Edit</button>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <button class="btn btn-secondary mt-4 add-payment">Add Payment Method</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                <div class="section general-info payment-info">
                                    <div class="info">
                                        <h6 class="">Add Billing Address</h6>
                                        <p>Changes your New <span class="text-success">Billing</span> Information.</p>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control add-billing-address-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Country</label>
                                                    <select class="form-select">
                                                        <option selected="">Choose...</option>
                                                        <option value="united-states">United States</option>
                                                        <option value="brazil">Brazil</option>
                                                        <option value="indonesia">Indonesia</option>
                                                        <option value="turkey">Turkey</option>
                                                        <option value="russia">Russia</option>
                                                        <option value="india">India</option>
                                                        <option value="germany">Germany</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">ZIP</label>
                                                    <input type="tel" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary mt-4">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                <div class="section general-info payment-info">
                                    <div class="info">
                                        <h6 class="">Add Payment Method</h6>
                                        <p>Changes your New <span class="text-success">Payment Method</span> Information.</p>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Card Brand</label>
                                                    <div class="invoice-action-currency">
                                                        <div class="dropdown selectable-dropdown cardName-select">
                                                            <a id="cardBrandDropdown" href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../src/assets/img/card-mastercard.svg" class="flag-width" alt="flag"> <span class="selectable-text">Mastercard</span> <span class="selectable-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span></a>
                                                            <div class="dropdown-menu" aria-labelledby="cardBrandDropdown">
                                                                <a class="dropdown-item" data-img-value="../src/assets/img/card-mastercard.svg" data-value="GBP - British Pound" href="javascript:void(0);"><img src="../src/assets/img/card-mastercard.svg" class="flag-width" alt="flag"> Mastercard</a>
                                                                <a class="dropdown-item" data-img-value="../src/assets/img/card-americanexpress.svg" data-value="IDR - Indonesian Rupiah" href="javascript:void(0);"><img src="../src/assets/img/card-americanexpress.svg" class="flag-width" alt="flag"> American Express</a>
                                                                <a class="dropdown-item" data-img-value="../src/assets/img/card-visa.svg" data-value="USD - US Dollar" href="javascript:void(0);"><img src="../src/assets/img/card-visa.svg" class="flag-width" alt="flag"> Visa</a>
                                                                <a class="dropdown-item" data-img-value="../src/assets/img/card-discover.svg" data-value="INR - Indian Rupee" href="javascript:void(0);"><img src="../src/assets/img/card-discover.svg" class="flag-width" alt="flag"> Discover</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Card Number</label>
                                                    <input type="text" class="form-control add-payment-method-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Holder Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">CVV/CVV2</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Card Expiry</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary mt-4">Add</button>
                                    </div>
                                </div>
                            </div>

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
