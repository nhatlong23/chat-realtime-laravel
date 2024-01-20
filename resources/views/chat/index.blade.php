@extends('layouts.app')

@section('content')
    @if (Auth::id())
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="row p-2">
                                    <div class="col-10">
                                        <div class="col-12 border rounded-lg p-3">
                                            <ul id="messages" class="list-unstyled overflow-auto" style="min-height: 45vh">
                                            </ul>
                                        </div>
                                        <form>
                                            <div class="row py-3">
                                                <div class="col-10">
                                                    <input type="text" id="message" class="form-control">
                                                </div>
                                                <div class="col-2">
                                                    <button id="send" type="submit"
                                                        class="btn btn-primary w-100">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-2">
                                        <p><strong>Người dùng online</strong></p>
                                        <ul id="users" class="list-unstyled overflow-auto text-info"
                                            style="min-height: 45vh">
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
        const messagesElement = document.getElementById('messages');

        Echo.join('chat')
            .here((users) => {
                users.forEach((users, index) => {
                    const li = document.createElement('li');
                    li.setAttribute('id', users.id);
                    li.innerText = users.name;

                    usersElement.appendChild(li);
                });
            })
            .joining((user) => {
                const li = document.createElement('li');
                li.setAttribute('id', user.id);
                li.innerText = user.name;

                usersElement.appendChild(li);
            })
            .leaving((user) => {
                const li = document.getElementById(user.id);
                if (li) {
                    li.parentNode.removeChild(li);
                }
            })
            .listen('MessageSent', (e) => {
                const li = document.createElement('li');
                li.innerText = e.user.name + ': ' + e.message;

                messagesElement.appendChild(li);
            });
    </script>

    <script type="module">
        const messageElement = document.getElementById('message');
        const sendElement = document.getElementById('send');

        sendElement.addEventListener('click', (e) => {
            e.preventDefault();

            window.axios.post('/chat/message', {
                message: messageElement.value
            });

            messageElement.value = '';
        });
    </script>
@endpush
