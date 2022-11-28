import './bootstrap';
import * as FilePond from 'filepond';

const inputElement = document.querySelector('input[type="file"]');
const pond = FilePond.create(inputElement);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
