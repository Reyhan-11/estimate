<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
        <!-- Register -->
        <div class="card" style="background-color: rgba(255, 255, 250, 0.8);">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    <a href="{{ url('') }}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('') }}" alt="logo" class="navbar-brand-img h-100" height="auto" width="250px">
                        </span>
                        <!-- <span class="app-brand-text demo text-body fw-bolder">IoT</span> -->
                    </a>
                </div>
                <!-- /Logo -->
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <form wire:submit.prevent="login" class="row g-3 needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" wire:model="username" placeholder="Enter your username" autofocus />
                        @error('username')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>