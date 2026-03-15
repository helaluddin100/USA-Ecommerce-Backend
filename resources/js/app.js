import './bootstrap';
import $ from 'jquery';
import 'select2/dist/css/select2.min.css';
import 'select2';

window.$ = window.jQuery = $;

function initSelect2() {
    if (typeof $.fn.select2 !== 'function') return;

    $('select').each(function () {
        const $el = $(this);
        if ($el.data('select2')) return;
        if ($el.hasClass('no-select2')) return;

        $el.select2({
            width: '100%',
            theme: 'default',
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSelect2();
});

