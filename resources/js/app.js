import './bootstrap';

import '../sass/app.scss'
import 'toastr/toastr.scss';
import toastr from 'toastr';
window.toastr = toastr;

Echo.private('notifications')
    .listen('UserSessionChanged', (e) => {
        // const notificationElement = document.getElementById('notification');

        // if (notificationElement) {
            // notificationElement.innerText = e.message;

            // notificationElement.classList.remove('invisible', 'alert-primary');
            // notificationElement.classList.add('alert-' + e.type);
            toastr[e.type](e.message)
        // } else {
        //     console.error('Element with ID "notification" not found.');
        // }
    });
