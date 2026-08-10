import './bootstrap';
import Alpine from 'alpinejs';
import guestForm from './alpine/guest-form';

window.Alpine = Alpine;

Alpine.data('guestForm', guestForm);

Alpine.start();
