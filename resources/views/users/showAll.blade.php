@extends('layouts.app')

@section('content')
    @if (Auth::id())
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <ul id="users"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <script>
            window.location = "/login";
        </script>
    @endif
@endsection

@push('scripts')
    <script type="module">
        const usersElement = document.getElementById('users');

        window.axios.get('/api/v1/users')
            .then(response => {
                const users = response.data;

                users.forEach((user, index) => {
                    const li = document.createElement('li');
                    li.setAttribute('id', user.id);
                    li.innerText = user.name;

                    usersElement.appendChild(li);
                });
            })
            .catch(error => {
                console.log(error);
            });
    </script>

    <script type="module">
        const usersElement = document.getElementById('users');

        Echo.channel('users')
            .listen('UserCreated', (event) => {
                const li = document.createElement('li');
                li.setAttribute('id', event.user.id);
                li.innerText = event.user.name;

                usersElement.appendChild(li);
            })
            .listen('UserUpdated', (event) => {
                const li = document.getElementById(event.user.id);
                li.innerText = event.user.name;
            })
            .listen('UserDeleted', (event) => {
                const li = document.getElementById(event.user.id);
                if (li) {
                    li.parentNode.removeChild(li);
                }
            });
    </script>
@endpush
